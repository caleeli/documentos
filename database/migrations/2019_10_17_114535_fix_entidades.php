<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixEntidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::select("SELECT setval('adm_entidad_ent_id_seq', max(ent_id)) FROM adm_entidad;");
        Schema::table('adm_entidad', function ($table) {
            $table->integer('user_add')->nullable()->default(null);
            $table->integer('user_mod')->nullable()->default(null);
            $table->integer('user_del')->nullable()->default(null);
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
            $table->dropColumn('user_add');
            $table->dropColumn('user_mod');
            $table->dropColumn('user_del');
        });
    }
}
