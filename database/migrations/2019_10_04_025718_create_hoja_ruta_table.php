<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHojaRutaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'hoja_ruta';

    /**
     * Run the migrations.
     * @table hoja_ruta
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('hr_scep_id');
            $table->date('fecha_recepcion')->nullable()->default(null);
            $table->char('referencia', 250);
            $table->char('procedencia', 200);
            $table->char('nro_de_control', 15);
            $table->char('anexo_hojas', 150);
            $table->char('destinatario', 80);
            $table->date('fecha_conclusion')->nullable()->default(null);
            $table->enum('tipo_hr', ['externa', 'interna', 'solicitud'])->nullable()->default('interna');
            $table->integer('gestion')->default('2018');
            $table->integer('numero');
            $table->string('tipo_tarea', 32)->nullable()->default(null);
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);
            $table->string('subtipo_tarea', 12)->nullable()->default(null);

            $table->unique(["gestion", "nro_de_control"], 'gestion_nro_de_control');
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
