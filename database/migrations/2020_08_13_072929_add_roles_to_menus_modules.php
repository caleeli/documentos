<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRolesToMenusModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->json('roles')->default('{"enabled":[]}');
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->json('roles')->default('{"enabled":[]}');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn(['roles']);
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['roles']);
        });
    }
}
