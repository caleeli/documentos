<?php

use Illuminate\Database\Migrations\Migration;

class CopyTableSolicitudes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('hr')->statement('CREATE TABLE hoja_ruta_solicitud LIKE hoja_ruta_externa;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
