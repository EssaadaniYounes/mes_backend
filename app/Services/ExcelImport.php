<?php


namespace App\Services;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelImport
{
    public function importAndSave($filePath)
    {
            $worksheet = (new Xlsx())->load($filePath)->getActiveSheet();

            $rows=[];
            $counter = 0;
            foreach ( $worksheet->getRowIterator() as $row) {
                if($counter++ == 0) continue;
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $cells = [];
                foreach($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                array_push($rows,$cells);
           }
            return $rows;

    }
}
