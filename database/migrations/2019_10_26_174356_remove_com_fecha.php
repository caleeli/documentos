<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveComFecha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comentario', function (Blueprint $table) {
            $table->dropColumn(['com_fecha']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comentario', function (Blueprint $table) {
            Schema::table('comentario', function (Blueprint $table) {
                $table->timestamp('com_fecha')->nullable();
            });
        });
    }
}
