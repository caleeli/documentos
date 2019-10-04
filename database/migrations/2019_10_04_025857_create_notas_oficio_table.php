<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotasOficioTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'notas_oficio';

    /**
     * Run the migrations.
     * @table notas_oficio
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('hoja_de_ruta', 80)->nullable()->default(null);
            $table->string('fecha_emision', 80)->nullable()->default(null);
            $table->string('nro_nota', 80)->nullable()->default(null);
            $table->string('reiterativa', 80)->nullable()->default(null);
            $table->string('fecha_entrega', 80)->nullable()->default(null);
            $table->string('entidad_empresa', 200)->nullable()->default(null);
            $table->string('nombre_apellidos', 200)->nullable()->default(null);
            $table->string('cargo', 100)->nullable()->default(null);
            $table->mediumText('referencia')->nullable()->default(null);
            $table->string('dias', 80)->nullable()->default(null);
            $table->string('retraso', 80)->nullable()->default(null);
            $table->mediumText('observaciones')->nullable()->default(null);
            $table->string('hoja_de_ruta_recepcion', 80)->nullable()->default(null);
            $table->string('fecha_recepcion', 80)->nullable()->default(null);
            $table->string('nro_nota_recepcion', 80)->nullable()->default(null);
            $table->string('remitente_recepcion', 200)->nullable()->default(null);
            $table->mediumText('referencia_recepcion')->nullable()->default(null);
            $table->string('fojas_recepcion', 80)->nullable()->default(null);
            $table->integer('gestion')->default('2018');
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
