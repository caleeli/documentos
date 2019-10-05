<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'adm_entidad';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('ent_id');
            $table->integer('ent_clasificador');
            $table->string('ent_descripcion');
            $table->string('ent_sigla');
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->timestamp('fecha_baja')->nullable();

            $table->unique(['ent_clasificador']);
            $table->unique(['ent_descripcion']);
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
