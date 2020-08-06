<?php

namespace App\Http\Controllers;

use App\JDD\ExcelReport;
use App\Reporte;
use App\Tarea;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{
    public function html(Reporte $reporte)
    {
        $res = $reporte->generar();
        return view('reportehtml', ['res' => $res, 'reporte' => $reporte]);
    }

    public function excel(Reporte $reporte)
    {
        $res = $reporte->generar();
        $header = [
            '#',
            'Tipo de HR',
            'Nro de Control',
            'Nro de Reg. Interno',
            'Fecha recepción',
            'Referencia',
            'Fecha derivación',
            'Destinatario',
            'Procecendia',
            'Adjunto',
            'Estado',
            'Última Instrucción',
        ];
        if ($reporte->tipo_tarea === "UR") {
            $header[] = 'Cant. Recibidos';
            $header[] = 'Cant. Atendidos';
            $header[] = 'Calificación';
        }
        $data = [];
        foreach ($res as $row) {
            $record = [
                $row['num'],
                Tarea::nombreTipoHR($row['tipo_hr']),
                $row['numero'],
                $row['nro_clasificacion'],
                $row['fecha_recepcion'],
                $row['referencia'],
                $row['derivacion_fecha'],
                $row['destinatario'],
                $row['procedencia'],
                $row['anexo_hojas'],
                $row['tar_estado'],
                $row['instruccion'],
            ];
            if ($reporte->tipo_tarea === 'UR') {
                $record[] = $row['tar_recibidos'];
                $record[] = $row['tar_atendidos'];
                $record[] = $row['tar_calificacion'];
            }
            $data [] = $record;
        }
        $excel = new ExcelReport(public_path('/images/logo128.png'), $header, $data);
        return $excel->download('reporte.xlsx');
    }

    public function pdf(Reporte $reporte)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        $res = $reporte->generar();
        $pdf = PDF::loadView('reportehtml', ['res' => $res, 'reporte' => $reporte])->setPaper('letter', 'landscape');
        return $pdf->download('listado.pdf');
    }
}
