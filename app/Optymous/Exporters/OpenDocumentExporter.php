<?php namespace App\Optymous\Exporters;

use App\Optymous\Exporters\Core\PhpExcelExporter;
use PHPExcel_Writer_OpenDocument;

class OpenDocumentExporter extends PhpExcelExporter {
    public function writer() {
        return new PHPExcel_Writer_OpenDocument($this->phpExcel);
    }

    public function extension() {
        return 'ods';
    }
}