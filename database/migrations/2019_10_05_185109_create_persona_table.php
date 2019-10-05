<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'adm_persona';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('per_id');
            $table->string('per_nombres');
            $table->string('per_apellidos');
            $table->string('per_ci_nit');
            $table->string('per_tipo_persona');
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->timestamp('fecha_baja')->nullable();
            $table->integer('user_add')->nullable();
            $table->integer('user_mod')->nullable();
            $table->integer('user_del')->nullable();

            $table->foreign('user_add')
                ->references('id')->on('adm_users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('user_mod')
                ->references('id')->on('adm_users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('user_del')
                ->references('id')->on('adm_users')
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
