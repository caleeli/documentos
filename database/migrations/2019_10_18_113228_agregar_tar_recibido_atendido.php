<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AgregarTarRecibidoAtendido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarea', function ($table) {
            $table->integer('tar_recibidos')->nullable();
            $table->integer('tar_atendidos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarea', function ($table) {
            $table->dropColumn(['tar_recibidos', 'tar_atendidos']);
        });
    }
}
