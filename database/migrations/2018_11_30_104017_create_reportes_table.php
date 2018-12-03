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
        Schema::connection('hr')->create('reportes',
            function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipo',
                    ['externa', 'interna', 'solicitud', 'notas', 'comunicacion', 'informes'])
                ->default('externa');
            $table->date('recepcion_desde')->nullable();
            $table->date('recepcion_hasta')->nullable();
            $table->string('referencia')->nullable();
            $table->string('procedencia')->nullable();
            $table->string('nro_de_control')->nullable();
            $table->date('conclusion_desde')->nullable();
            $table->date('conclusion_hasta')->nullable();
            $table->string('gestion_desde', 4)->nullable();
            $table->string('gestion_hasta', 4)->nullable();
            $table->string('destinatario')->nullable();
            $table->string('tipo_tarea')->nullable();
            $table->enum('tipo_reporte',
                ['hoja_ruta', 'derivacion', 'detallada'])->default('hoja_ruta');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('hr')->dropIfExists('reportes');
    }
}
