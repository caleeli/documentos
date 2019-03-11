<?php

namespace App\Http\Controllers;

use App\Reporte;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{

    public function html(Reporte $reporte)
    {
        $res = $reporte->generar();
        return view('reportehtml', ['res' => $res]);
    }

    public function excel(Reporte $reporte)
    {
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=reporte.xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        $res = $reporte->generar();
        return view('reportehtml', ['res' => $res]);
    }

    public function pdf(Reporte $reporte)
    {
        set_time_limit(0);
        $res = $reporte->generar();
        $pdf = PDF::loadView('reportehtml', ['res' => $res])->setPaper('letter', 'landscape');
        return $pdf->download('listado.pdf');
    }
}
