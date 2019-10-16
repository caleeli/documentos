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
            $table->timestamp('fecha_recepcion')->nullable()->default(null);
            $table->string('referencia')->nullable()->default(null);
            $table->string('procedencia')->nullable()->default(null);
            $table->string('nro_de_control');
            $table->string('anexo_hojas')->nullable()->default(null);
            $table->string('destinatario')->nullable()->default(null);
            $table->timestamp('fecha_conclusion')->nullable()->default(null);
            $table->enum('tipo_hr', ['externa', 'interna', 'solicitud'])->nullable()->default('interna');
            $table->integer('gestion')->default(Date('Y'));
            $table->integer('numero');
            $table->string('tipo_tarea')->nullable()->default(null);
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);
            $table->string('subtipo_tarea')->nullable()->default(null);
            $table->string('tipo_procedencia')->nullable();

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
