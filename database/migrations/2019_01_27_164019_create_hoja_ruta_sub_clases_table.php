<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHojaRutaSubClasesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_ruta_sub_clases',
            function (Blueprint $table) {
            $table->string('sub_clase_id', 12);
            $table->string('nombre');
            $table->unsignedInteger('clasificacion_id');
            $table->primary('sub_clase_id');
            $table->foreign('clasificacion_id')->references('id')->on('hoja_ruta_clasificacion');
        });
        Schema::table('hoja_ruta',
            function (Blueprint $table) {
            $table->string('subtipo_tarea', 12)->nullable()->add();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoja_ruta_sub_clases');
    }
}
