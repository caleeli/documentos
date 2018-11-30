<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes',
            function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipo',
                    ['externa', 'interna', 'solicitud', 'notas', 'comunicacion', 'informes'])
                ->default('externa');
            $table->date('recepcion_desde');
            $table->date('recepcion_hasta');
            $table->string('referencia');
            $table->string('procedencia');
            $table->string('nro_de_control');
            $table->date('conclusion_desde');
            $table->date('conclusion_hasta');
            $table->string('gestion_desde', 4);
            $table->string('gestion_hasta', 4);
            $table->string('destinatario');
            $table->string('tipo_tarea');
            $table->enum('tipo_reporte',
                ['hoja_ruta', 'derivacion', 'detallada'])->default('hoja_ruta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportes');
    }
}
