<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCalificacionAsignaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarea_user', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at', 'deleted_at']);
            $table->integer('calificacion')->nullable();
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->timestamp('fecha_baja')->nullable();
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarea_user', function (Blueprint $table) {
            $table->dropColumn(['calificacion', 'fecha_registro', 'fecha_modificacion', 'fecha_baja', 'user_add', 'user_mod', 'user_del']);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
}
