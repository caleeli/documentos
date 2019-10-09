<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunicacionesInternasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comunicaciones_internas';

    /**
     * Run the migrations.
     * @table comunicaciones_internas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('hoja_de_ruta')->nullable()->default(null);
            $table->string('fecha_emision')->nullable()->default(null);
            $table->string('nro_nota')->nullable()->default(null);
            $table->string('reiterativa')->nullable()->default(null);
            $table->string('fecha_entrega')->nullable()->default(null);
            $table->string('gerencia_subcontraloria')->nullable()->default(null);
            $table->string('nombre_apellidos')->nullable()->default(null);
            $table->string('cargo')->nullable()->default(null);
            $table->mediumText('referencia')->nullable()->default(null);
            $table->string('dias')->nullable()->default(null);
            $table->string('retraso')->nullable()->default(null);
            $table->mediumText('observaciones')->nullable()->default(null);
            $table->string('hoja_de_ruta_recepcion')->nullable()->default(null);
            $table->string('fecha_recepcion')->nullable()->default(null);
            $table->string('nro_nota_recepcion')->nullable()->default(null);
            $table->string('remitente_recepcion')->nullable()->default(null);
            $table->mediumText('referencia_recepcion')->nullable()->default(null);
            $table->string('fojas_recepcion')->nullable()->default(null);
            $table->integer('gestion')->default(date('Y'));

            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->timestamp('fecha_baja')->nullable();
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);

            $table->index(['gerencia_subcontraloria'], 'gerencia_subcontraloria');
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
