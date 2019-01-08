<?php

use Illuminate\Database\Migrations\Migration;

class DivideHojaRuta extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('hr')->transaction(function() {
            $this->fixDate('hoja_ruta', ['fecha', 'conclusion']);
            DB::connection('hr')->statement('CREATE TABLE hoja_ruta_interna LIKE hoja_ruta;');
            DB::connection('hr')->statement('INSERT hoja_ruta_interna SELECT * FROM hoja_ruta WHERE tipo="interna";');
            DB::connection('hr')->statement('ALTER TABLE `hoja_ruta` RENAME TO `hoja_ruta_externa`;');
            DB::connection('hr')->statement('DELETE FROM hoja_ruta_externa WHERE tipo="interna";');
        });
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

    /**
     * Fix date nullable
     */
    private function fixDate($table, $columns)
    {
        foreach ($columns as $column) {
            DB::connection('hr')->statement('UPDATE `' . $table . '` SET `' . $column . '` = "1797-07-07" WHERE `' . $column . '`="0000-00-00";');
        }
        foreach ($columns as $column) {
            DB::connection('hr')->statement('ALTER TABLE `' . $table . '` CHANGE `' . $column . '` `' . $column . '` date NULL;');
        }
        foreach ($columns as $column) {
            DB::connection('hr')->statement('UPDATE `' . $table . '` SET `' . $column . '` = null WHERE `' . $column . '`="1797-07-07";');
        }
    }
}
