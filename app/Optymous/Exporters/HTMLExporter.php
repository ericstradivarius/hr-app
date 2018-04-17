<?php namespace App\Optymous\Exporters;

use App\Optymous\Exporters\Core\PhpExcelExporter;
use PHPExcel_Writer_HTML;

class HTMLExporter extends PhpExcelExporter {
    public function writer() {
        return new PHPExcel_Writer_HTML($this->phpExcel);
    }

    public function extension() {
        return 'html';
    }
}