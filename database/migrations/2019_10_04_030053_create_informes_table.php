<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'informes';

    /**
     * Run the migrations.
     * @table informes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('nro_inf_id');
            $table->dateTime('fecha_entrega');
            $table->string('nombre_destinatario', 200);
            $table->string('nombre_remitente', 200);
            $table->text('referencia');
            $table->integer('ref_hoja_ruta');
            $table->string('nro_informe', 80)->nullable();
            $table->string('gestion', 4)->default(date('Y'));

            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->timestamp('fecha_baja')->nullable();
            $table->integer('user_add')->nullable();
            $table->integer('user_mod')->nullable();
            $table->string('user_del')->nullable();

            $table->index(["ref_hoja_ruta"], 'informes_ref_hoja_ruta_foreign');

            $table->foreign('ref_hoja_ruta', 'informes_ref_hoja_ruta_foreign')
                ->references('hr_id')->on('hoja_ruta')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
