<?php namespace App\Optymous\Exporters;

use App\Optymous\Exporters\Core\PhpExcelExporter;
use PHPExcel_Writer_CSV;

class CSVExporter extends PhpExcelExporter {
    public function writer() {
        return new PHPExcel_Writer_CSV($this->phpExcel);
    }

    public function extension() {
        return 'csv';
    }
}