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
            $table->increments('hr_id');
            $table->date('fecha_recepcion')->nullable()->default(null);
            $table->string('referencia', 250)->nullable()->default(null);
            $table->string('procedencia', 200)->nullable()->default(null);
            $table->string('nro_de_control', 15);
            $table->string('anexo_hojas', 150)->nullable()->default(null);
            $table->string('destinatario', 80)->nullable()->default(null);
            $table->date('fecha_conclusion')->nullable()->default(null);
            $table->enum('tipo_hr', ['externa', 'interna', 'solicitud'])->nullable()->default('interna');
            $table->integer('gestion')->default(Date('Y'));
            $table->integer('numero');
            $table->string('tipo_tarea', 32)->nullable()->default(null);
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);
            $table->string('subtipo_tarea', 12)->nullable()->default(null);
            $table->string('tipo_procedencia', 30);

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
