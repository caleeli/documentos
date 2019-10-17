<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class FixEntidadesRequiredFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adm_entidad', function ($table) {
            $table->integer('ent_clasificador')->nullable()->change();
            $table->string('ent_sigla')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adm_entidad', function ($table) {
            $table->integer('ent_clasificador')->change();
            $table->string('ent_sigla')->change();
        });
    }
}
