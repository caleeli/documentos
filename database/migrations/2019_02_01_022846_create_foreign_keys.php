<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration
{

    public function up()
    {
        Schema::table('informes',
            function(Blueprint $table) {
            $table->foreign('ref_hoja_ruta')->references('hr_scep_id')->on('hoja_ruta')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::table('informes',
            function(Blueprint $table) {
            $table->dropForeign('informes_ref_hoja_ruta_foreign');
        });
    }
}
