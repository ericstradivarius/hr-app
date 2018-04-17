<?php namespace App\Optymous\Exporters;

use App\Optymous\Exporters\Core\PhpExcelExporter;
use PHPExcel_Writer_Excel2007;

class Excel2007Exporter extends PhpExcelExporter {
    public function writer() {
        return new PHPExcel_Writer_Excel2007($this->phpExcel);
    }

    public function extension() {
        return 'xlsx';
    }
}