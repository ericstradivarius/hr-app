<?php namespace App\Optymous\Exporters;

use App\Optymous\Exporters\Core\PhpExcelExporter;
use PHPExcel_Writer_Excel5;

class Excel5Exporter extends PhpExcelExporter {
    public function writer() {
        return new PHPExcel_Writer_Excel5($this->phpExcel);
    }

    public function extension() {
        return 'xls';
    }
}