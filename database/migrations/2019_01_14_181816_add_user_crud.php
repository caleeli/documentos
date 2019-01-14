<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserCrud extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createTimestamps('hoja_ruta');
        $this->createTimestamps('derivacion');
        $this->createTimestamps('reportes');
    }

    private function createTimestamps($table)
    {
        Schema::table($table,
            function (Blueprint $table) {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        DB::connection('hr')->statement("ALTER TABLE `$table` ADD `user_add` int(11) NULL;");
        DB::connection('hr')->statement("ALTER TABLE `$table` ADD `user_mod` int(11) NULL;");
        DB::connection('hr')->statement("ALTER TABLE `$table` ADD `user_del` int(11) NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
