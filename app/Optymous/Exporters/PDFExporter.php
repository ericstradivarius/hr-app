<?php namespace App\Optymous\Exporters;

use App\Optymous\Exporters\Core\PhpExcelExporter;
use Illuminate\Database\Eloquent\Builder;
use PHPExcel_Settings;
use PHPExcel_Writer_PDF;

class PDFExporter extends PhpExcelExporter {
    public function writer() {
        return new PHPExcel_Writer_PDF($this->phpExcel);
    }

    public function handle(Builder $model, $filename) {
        PHPExcel_Settings::setPdfRenderer(PHPExcel_Settings::PDF_RENDERER_DOMPDF, __DIR__ . '/Core');

        return parent::handle($model, $filename);
    }

    public function extension() {
        return 'pdf';
    }
}