<?php

use Illuminate\Database\Migrations\Migration;

class AgregarFirma extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('hr')->statement("ALTER TABLE `derivacion` ADD `firma` text COLLATE 'utf8_general_ci' NULL;");
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
