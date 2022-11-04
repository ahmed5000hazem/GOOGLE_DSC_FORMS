<?php
namespace App\Services;

use Spatie\SimpleExcel\SimpleExcelReader;

class ExcelHandelerService {
    public function readHeaders($path)
    {
        return SimpleExcelReader::create($path)->getHeaders();
    }
}