<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdmPersonaRemoveApellidosNotNull extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'adm_persona';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function ($table) {
            $table->string('per_apellidos')->nullable()->change();
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
            $table->string('per_apellidos')->nullable(false)->change();
        });
    }
}
