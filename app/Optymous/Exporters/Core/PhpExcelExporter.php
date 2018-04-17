<?php namespace App\Optymous\Exporters\Core;

use Illuminate\Database\Eloquent\Builder;
use PHPExcel;

abstract class PhpExcelExporter extends Exporter {
    protected $phpExcel;

    private $cursor;

    public function handle(Builder $model, $filename) {
        $this->phpExcel = new PHPExcel();
        $this->cursor = 1;

        return parent::handle($model, $filename);
    }

    public function partial($data) {
        $this->phpExcel->getActiveSheet()->fromArray($data, null, 'A' . $this->cursor);
        $this->cursor += count($data);
    }
}