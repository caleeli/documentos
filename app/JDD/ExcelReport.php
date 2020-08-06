<?php

namespace App\JDD;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelReport
{
    private $banner ='';
    private $header ='';
    private $data = [];

    /**
     * @var Spreadsheet
     */
    private $excel;

    /**
     * @var Worksheet
     */
    private $hoja;

    public function __construct($banner, $header, $data)
    {
        $this->excel = new Spreadsheet();
        $sheet = $this->hoja = $this->excel->getActiveSheet();
        $row = 1;
        // Add banner
        if ($banner) {
            $this->addBanner($banner, $sheet);
            $row += 3;
        }
        // Add header row
        foreach ($header as $i => $title) {
            $col = $i + 1;
            $sheet->setCellValueByColumnAndRow($col, $row, $title);
            $sheet->getStyleByColumnAndRow($col, $row)
                ->applyFromArray([
                    'font' => ['bold' => true],
                    'borders' => array(
                        'outline' => array(
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                ]);
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
        $row++;
        // Add data
        foreach ($data as $fila) {
            foreach ($fila as $c => $celda) {
                $col = $c + 1;
                $sheet->setCellValueByColumnAndRow($col, $row, $celda);
                $sheet->getStyleByColumnAndRow($col, $row)
                ->applyFromArray([
                    'borders' => array(
                        'outline' => array(
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                ]);
            }
            $row++;
        }
        $sheet->calculateColumnWidths();
    }

    private function addBanner($banner, $hoja)
    {
        if (substr($banner, 0, 4) === 'http') {
            $name = uniqid('img', true) . basename($banner);
            Storage::disk('local')->put($name, file_get_contents($banner));
            $path = Storage::disk('local')->path($name);
        } else {
            $path = $banner;
        }
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath($path); // put your path and image here
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(0);
        $drawing->setOffsetY(0);
        $drawing->setHeight(40);
        $drawing->setRotation(0);
        $drawing->setWorksheet($hoja);
    }

    public function download($name)
    {
        $writer = new Xlsx($this->excel);
        $file = storage_path(uniqid('app/report', true) . '.xlsx');
        $writer->save($file);
        return response()->download($file, $name);
    }
}
