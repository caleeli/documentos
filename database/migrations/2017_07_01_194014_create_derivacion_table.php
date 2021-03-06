<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDerivacionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'derivacion';

    /**
     * Run the migrations.
     * @table derivacion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha')->nullable()->default(null);
            $table->string('comentarios')->nullable()->default(null);
            $table->string('instruccion')->nullable()->default(null);
            $table->integer('hoja_ruta_id');
            $table->string('destinatarios')->nullable()->default(null);
            $table->string('destinatario')->nullable()->default(null);
            $table->integer('dias_plazo')->nullable();
            $table->text('firma')->nullable()->default(null);
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);

            $table->index(["hoja_ruta_id"], 'hoja_ruta_id');

            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('hoja_ruta_id')
                ->references('hr_id')->on('hoja_ruta')
                ->onDelete('cascade')
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
