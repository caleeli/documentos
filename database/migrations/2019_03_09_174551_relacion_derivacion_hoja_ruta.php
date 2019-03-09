<?php

use Illuminate\Database\Migrations\Migration;

class RelacionDerivacionHojaRuta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = DB::connection('hr');
        // Elimina las derivaciones sin hoja de ruta
        $connection->statement('delete from derivacion where hoja_ruta_id not in (select hr_scep_id from hoja_ruta)');
        $connection->statement('ALTER TABLE `derivacion` '
            . 'CHANGE `hoja_ruta_id` `hoja_ruta_id` int(10) NOT NULL AFTER `instruccion`, '
            . 'ADD FOREIGN KEY (`hoja_ruta_id`) REFERENCES `hoja_ruta` (`hr_scep_id`) ON DELETE CASCADE;');
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
