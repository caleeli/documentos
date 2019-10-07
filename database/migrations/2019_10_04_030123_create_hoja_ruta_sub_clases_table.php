<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHojaRutaSubClasesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'hoja_ruta_sub_clases';

    /**
     * Run the migrations.
     * @table hoja_ruta_sub_clases
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->numeric('sub_clase_id');
            $table->string('nombre');
            $table->unsignedInteger('clasificacion_id');

            $table->primary('sub_clase_id');
            $table->index(["clasificacion_id"], 'hoja_ruta_sub_clases_clasificacion_id_foreign');


            $table->foreign('clasificacion_id', 'hoja_ruta_sub_clases_clasificacion_id_foreign')
                ->references('id')->on('hoja_ruta_clasificacion')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
