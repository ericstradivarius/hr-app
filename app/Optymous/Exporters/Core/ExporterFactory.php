<?php

namespace App\Optymous\Exporters\Core;

use App\Optymous\Exporters\CSVExporter;
use App\Optymous\Exporters\Excel2007Exporter;
use App\Optymous\Exporters\Excel5Exporter;
use App\Optymous\Exporters\HTMLExporter;
use App\Optymous\Exporters\OpenDocumentExporter;
use App\Optymous\Exporters\PDFExporter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ExporterFactory {

    public function handle(Request $request, Builder $repository) {
        try {
            return [
                'url' => $this->chooseExporter(
                    $request->input('type'),
                    $repository,
                    $request->input('filename')
                )
            ];
        } catch(\Exception $exception) {
            return ["error" => $exception->getMessage()];
        }
    }

    private function chooseExporter($type, $repository, $filename) {

        switch($type) {
            case 'csv':
                return (new CSVExporter())->handle($repository, $filename);
            case 'xls':
                return (new Excel5Exporter())->handle($repository, $filename);
            case 'xlsx':
                return (new Excel2007Exporter())->handle($repository, $filename);
            case 'html':
                return (new HTMLExporter())->handle($repository, $filename);
            case 'ods':
                return (new OpenDocumentExporter())->handle($repository, $filename);
            case 'pdf':
                return (new PDFExporter())->handle($repository, $filename);
            default:
                throw(new \Exception('Invalid export type.'));

        }
    }
}