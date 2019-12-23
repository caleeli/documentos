<?php

use App\HojaRuta;
use App\HojaRutaSubClases;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubClasificacionHr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hoja_ruta_sub_clases', function (Blueprint $table) {
            $table->string('sigla')->nullable();
        });
        Schema::table('hoja_ruta', function (Blueprint $table) {
            $table->string('nro_clasificacion')->nullable();
            $table->integer('contador_clasificacion')->nullable();
        });
        foreach (HojaRutaSubClases::all() as $sub) {
            preg_match_all('/[a-zÀ-ú]{4,}/i', $sub->nombre, $match);
            $sigla = '';
            $size = ceil(6 / count($match[0]));
            foreach ($match[0] as $ma) {
                $sigla .= mb_strtoupper(substr($ma, 0, $size));
            }
            $sub->sigla = $sigla;
            $sub->save();
        }
        HojaRuta::createNroClasificacion();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hoja_ruta_sub_clases', function (Blueprint $table) {
            $table->dropColumn(['sigla']);
        });
        Schema::table('hoja_ruta', function (Blueprint $table) {
            $table->dropColumn(['nro_clasificacion','contador_clasificacion']);
        });
    }
}
