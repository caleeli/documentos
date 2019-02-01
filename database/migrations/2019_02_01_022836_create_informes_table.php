<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInformesTable extends Migration
{

    public function up()
    {
        DB::connection('hr')->statement("ALTER TABLE `hoja_ruta` CHANGE `hr_scep_id` `hr_scep_id` int(10) NOT NULL AUTO_INCREMENT FIRST;");
        Schema::create('informes',
            function(Blueprint $table) {
            $table->increments('nro_inf_id');
            $table->timestamps();
            $table->softDeletes();
            $table->datetime('fecha_entrega');
            $table->string('nombre_destinatario', 200);
            $table->string('nombre_remitente', 200);
            $table->text('referencia');
            $table->integer('ref_hoja_ruta');
            $table->text('archivo_adjunto');
            $table->integer('numero');
            $table->string('gestion', 4);
            $table->integer('user_add');
            $table->integer('user_mod');
            $table->string('user_del');
        });
    }

    public function down()
    {
        Schema::drop('informes');
    }
}
