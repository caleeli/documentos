<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixNroDeControl extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = DB::connection('hr');
        $duplicados = $connection->select("select hoja_ruta.* from hoja_ruta right join 
            (SELECT nro_de_control, gestion
            FROM `hoja_ruta`
            group by nro_de_control, gestion
            having count(*) > 1) duplicado on 
            (hoja_ruta.nro_de_control=duplicado.nro_de_control and hoja_ruta.gestion=duplicado.gestion)
            order by gestion, nro_de_control, hr_scep_id");
        $prev = null;
        foreach ($duplicados as $dup) {
            $sufixIndex = $prev && $dup->nro_de_control === $prev->nro_de_control
                && $dup->gestion === $prev->gestion ? $sufixIndex + 1 : 0;
            $sufix = $sufixIndex ? '-' . chr(64 + $sufixIndex) : '';
            $prev = $dup;
            if(!$sufix) {
                continue;
            }
            $id = $dup->hr_scep_id;
            $nro_de_control = $dup->nro_de_control . $sufix;
            $connection->table('hoja_ruta')
                ->where('hr_scep_id', $id)
                ->update([
                    'nro_de_control' => $nro_de_control,
            ]);
        }
        $connection->statement('ALTER TABLE `hoja_ruta` ADD UNIQUE `gestion_nro_de_control` (`gestion`, `nro_de_control`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
