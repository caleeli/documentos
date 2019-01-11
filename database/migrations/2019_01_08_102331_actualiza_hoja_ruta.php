<?php

use Illuminate\Database\Migrations\Migration;

class ActualizaHojaRuta extends Migration
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
            DB::connection('hr')->statement('ALTER TABLE `hoja_ruta` CHANGE `id` `hr_scep_id` int(11) NOT NULL AUTO_INCREMENT;');
            DB::connection('hr')->statement('ALTER TABLE `hoja_ruta` CHANGE `fecha` `fecha_recepcion` date NULL;');
            DB::connection('hr')->statement('ALTER TABLE `hoja_ruta` CHANGE `conclusion` `fecha_conclusion` date NULL;');
            DB::connection('hr')->statement("ALTER TABLE `hoja_ruta` CHANGE `tipo` `tipo_hr` enum('externa','interna','solicitud') COLLATE 'utf8_general_ci' NULL DEFAULT 'interna';");
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
