<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->increments('com_id');
            $table->integer('tar_id');
            $table->timestamp('com_fecha')->nullable();
            $table->text('com_texto')->nullable();

            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->timestamp('fecha_baja')->nullable();
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);

            $table->foreign('tar_id')
                ->references('tar_id')->on('tarea')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario');
    }
}
