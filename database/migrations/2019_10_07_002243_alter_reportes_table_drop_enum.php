<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReportesTableDropEnum extends Migration
{

    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'reportes';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['tipo_reporte', 'tipo']);
        });
           Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('tipo_reporte','100')->nullable();
            $table->string('tipo','100')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['tipo_reporte', 'tipo']);
        });
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->enum('tipo_reporte', ['hoja_ruta', 'derivacion', 'detallada'])->default('hoja_ruta');
            $table->enum('tipo', ['externa', 'interna', 'solicitud', 'notas', 'comunicacion', 'informes'])->default('externa');
        });
    }
}
