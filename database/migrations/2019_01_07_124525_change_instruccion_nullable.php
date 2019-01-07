<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInstruccionNullable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('hr')->statement('UPDATE `derivacion` SET `fecha` = "1797-07-07" WHERE `fecha`="0000-00-00";');
        Schema::table('derivacion',
            function (Blueprint $table) {

            // change() tells the Schema builder that we are altering a table
            $table->string('instruccion')->nullable()->change();
            $table->date('fecha')->nullable()->change();
            
        });
        DB::connection('hr')->statement('UPDATE `derivacion` SET `fecha` = null WHERE `fecha`="1797-07-07";');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
