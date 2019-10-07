<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmTareasTable extends Migration
{
    public function up()
    {
        Schema::create('tarea', function (Blueprint $table) {
            $table->increments('tar_id');
            $table->integer('hr_id')->nullable();
            $table->integer('derhr_id')->nullable();

            $table->string('tar_codigo');
            $table->string('tar_descripcion')->default('');
            $table->timestamp('tar_fecha_derivacion')->nullable();
            $table->timestamp('tar_fecha_fin')->nullable();
            $table->string('tar_estado');
            $table->integer('tar_avance')->default(0);
            $table->integer('tar_prioridad')->default(3);
            $table->text('tar_comentarios')->nullable();

            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->timestamp('fecha_baja')->nullable();
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);

            $table->foreign('hr_id')
                ->references('hr_id')->on('hoja_ruta')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('derhr_id')
                ->references('id')->on('derivacion')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adm_tareas');
    }
}
