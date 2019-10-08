<?php

namespace App\Http\Controllers;

use App\HojaRuta;

class ImpresionHRController extends Controller
{
    public function show(HojaRuta $hojaRuta, $pos)
    {
        $hoja = $hojaRuta->toArray();
        $hoja['anexoHojas_fjs'] = preg_match('/(\d+)\s*fjs/i', $hoja['anexo_hojas'], $ma) ? $ma[1] : '';
        $hoja['anexoHojas_arch'] = preg_match('/(\d+)\s*arc/i', $hoja['anexo_hojas'], $ma) ? $ma[1] : '';
        $hoja['anexoHojas_ani'] = preg_match('/(\d+)\s*ani/i', $hoja['anexo_hojas'], $ma) ? $ma[1] : '';
        $hoja['anexoHojas_leg'] = preg_match('/(\d+)\s*leg/i', $hoja['anexo_hojas'], $ma) ? $ma[1] : '';
        $hoja['anexoHojas_eje'] = preg_match('/(\d+)\s*eje/i', $hoja['anexo_hojas'], $ma) ? $ma[1] : '';
        $hoja['anexoHojas_eng'] = preg_match('/(\d+)\s*eng/i', $hoja['anexo_hojas'], $ma) ? $ma[1] : '';
        $hoja['anexoHojas_cd'] = preg_match('/(\d+)\s*cd/i', $hoja['anexo_hojas'], $ma) ? $ma[1] : '';
        return view('impresion_hr', compact('hoja', 'pos'));
    }
}
