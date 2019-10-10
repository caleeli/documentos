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
            $table->increments('id');
            $table->string('hoja_de_ruta')->nullable()->default(null);
            $table->date('fecha_emision')->nullable()->default(null);
            $table->string('nro_nota')->nullable()->default(null);
            $table->string('reiterativa')->nullable()->default(null);
            $table->date('fecha_entrega')->nullable()->default(null);
            $table->string('entidad_empresa')->nullable()->default(null);
            $table->string('nombre_apellidos')->nullable()->default(null);
            $table->string('cargo')->nullable()->default(null);
            $table->mediumText('referencia')->nullable()->default(null);
            $table->string('dias')->nullable()->default(null);
            $table->string('retraso')->nullable()->default(null);
            $table->mediumText('observaciones')->nullable()->default(null);
            $table->string('hoja_de_ruta_recepcion')->nullable()->default(null);
            $table->date('fecha_recepcion')->nullable()->default(null);
            $table->string('nro_nota_recepcion')->nullable()->default(null);
            $table->string('remitente_recepcion')->nullable()->default(null);
            $table->mediumText('referencia_recepcion')->nullable()->default(null);
            $table->string('fojas_recepcion')->nullable()->default(null);
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
