<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInstruccionesModifyLength extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'instrucciones';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function ($table) {
            $table->string('sigla', 30)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function ($table) {
            $table->string('sigla', 3)->change();
        });
    }
}
