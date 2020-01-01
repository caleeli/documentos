<?php

use App\HojaRuta;
use App\HojaRutaSubClases;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CorregirSubClasificacionSigla extends Migration
{
    private $siglas = [
        '1.1' => 'UR-PROC',
        '1.2' => 'UR-CONT',
        '1.3' => 'UR-ASUS',
        '1.4' => 'UR-DESC',
        '1.5' => 'UR-BASIS',
        '1.6' => 'UR-CEXIN',
        '1.7' => 'UR-ESOLV',
        '1.8' => 'UR-RDJBR',
        '1.9' => 'UR-BDJBR',
        '1.10' => 'UR-SDJBR',
        '1.11' => 'UR-RF',
        '1.12' => 'UR-OJ',
        '1.13' => 'UR-OTR',
        '2.1' => 'GSL-SOPLE',
        '2.2' => 'GSL-SALAE',
        '2.3' => 'GSL-SOLIC',
        '2.4' => 'GSL-ELIAI',
        '2.5' => 'GSL-ILIAE',
        '2.6' => 'GSL-RLIC',
        '2.7' => 'GSL-ILEIA',
        '2.8' => 'GSL-RESCE',
        '2.9' => 'GSL-EOLCI',
        '2.10' => 'GSL-AERSL',
        '2.11' => 'GSL-ICESL',
        '2.12' => 'GSL-ISESL',
        '2.13' => 'GSL-REPN',
        '2.14' => 'GSL-EPRES',
        '2.15' => 'GSL-ELINF',
        '2.16' => 'GSL-ELMEM',
        '2.17' => 'GSL-OTR',
        '3.1' => 'GAAJ-BREPR',
        '3.2' => 'GAAJ-EREPR',
        '3.3' => 'GAAJ-CEDNE',
        '3.4' => 'GAAJ-DIBIE',
        '3.5' => 'GAAJ-OCOEX',
        '3.6' => 'GAAJ-AADIN',
        '3.7' => 'GAAJ-CONT',
        '3.8' => 'GAAJ-NOR',
        '3.9' => 'GAAJ-RES',
        '3.10' => 'GAAJ-INF',
        '3.11' => 'GAAJ-OFI',
        '3.12' => 'GAAJ-CI',
        '3.13' => 'GAAJ-OTR',
        '4.1' => 'SC-CI',
        '4.2' => 'SC-INF',
        '4.3' => 'SC-NOT',
        '4.4' => 'SC-OTR',
    ];

    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (HojaRutaSubClases::all() as $sub) {
            $sigla = $this->siglas[$sub->getKey()] ?? null;
            if ($sigla) {
                $sub->sigla = $sigla;
                $sub->save();
            }
        }
        foreach (HojaRutaSubClases::all() as $sub) {
            foreach (HojaRuta::where('subtipo_tarea', $sub->sub_clase_id)->get() as $hoja) {
                DB::table('hoja_ruta')->where('hr_id', $hoja->getKey())->update([
                    'nro_clasificacion' => $sub->sigla . '-' . $hoja->contador_clasificacion,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
