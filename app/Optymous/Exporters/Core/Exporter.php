<?php namespace App\Optymous\Exporters\Core;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Exporter {
    abstract function writer();

    abstract function partial($data);

    abstract function extension();

    private $exportName;

    public function handle(Builder $model, $filename) {
        $columns = $this->columns($model);

        $this->partial([$columns]);
        $model->chunk(2, function($collection) use($columns, $filename) {
            $this->partial($this->data($collection, $columns));
        });

        $path = $this->path($filename);
        $this->writer()->save($path);

        return $this->getExportUrl();
    }

    protected function columns(Builder $model) {
        return array_keys($model->first()->getAttributes());
    }

    protected function data(Collection $collection, $columns) {
        $data = [];

        foreach($collection as $item) {
            $data[] = $this->item($item, $columns);
        }

        return $data;
    }

    protected function item(Model $model, $columns) {
        $data = [];

        foreach($columns as $column) {
            $data[] = $this->value($model[$column]);
        }

        return $data;
    }

    protected function value($value) {
        return is_null($value) ? '' : (string)$value;
    }

    protected function directory() {
        $path = public_path('exports');

        if(!is_dir($path)) {
            mkdir($path, 0755);
        }

        return $path;
    }

    protected function path($filename) {

        $this->generateExportName($filename);
        return $this->directory() . '/' . $this->exportName;
    }

    protected function timestamp() {
        return date('Y_m_d_His');
    }

    protected function generateExportName($filename) {
        $this->exportName = $filename . '_' . $this->timestamp() . '.' . $this->extension();
    }

    protected function getExportUrl() {
        return asset('exports/' . $this->exportName);
    }
}