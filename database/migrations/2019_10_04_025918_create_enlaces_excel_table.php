<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnlacesExcelTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'enlaces_excel';

    /**
     * Run the migrations.
     * @table enlaces_excel
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('origen', 100);
            $table->string('origen_hoja', 100);
            $table->string('destino', 100);
            $table->string('destino_hoja', 100);

            $table->unique(["destino", "destino_hoja"], 'destino_destino_hoja');
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
