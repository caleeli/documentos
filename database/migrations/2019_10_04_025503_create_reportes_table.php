<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'reportes';

    /**
     * Run the migrations.
     * @table reportes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->enum('tipo', ['externa', 'interna', 'solicitud', 'notas', 'comunicacion', 'informes'])->default('externa');
            $table->date('recepcion_desde')->nullable()->default(null);
            $table->date('recepcion_hasta')->nullable()->default(null);
            $table->string('referencia')->nullable()->default(null);
            $table->string('procedencia')->nullable()->default(null);
            $table->string('nro_de_control')->nullable()->default(null);
            $table->date('conclusion_desde')->nullable()->default(null);
            $table->date('conclusion_hasta')->nullable()->default(null);
            $table->string('gestion_desde', 4)->nullable()->default(null);
            $table->string('gestion_hasta', 4)->nullable()->default(null);
            $table->string('destinatario')->nullable()->default(null);
            $table->string('tipo_tarea')->nullable()->default(null);
            $table->enum('tipo_reporte', ['hoja_ruta', 'derivacion', 'detallada'])->default('hoja_ruta');
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
