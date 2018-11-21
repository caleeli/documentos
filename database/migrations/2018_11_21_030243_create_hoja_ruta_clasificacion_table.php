<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHojaRutaClasificacionTable extends Migration
{

    protected $connection = 'hr';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hr')->create('hoja_ruta_clasificacion',
            function (Blueprint $table) {
            $table->increments('id');
            $table->string('sigla', 3);
            $table->string('nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoja_ruta_clasificacion');
    }
}
