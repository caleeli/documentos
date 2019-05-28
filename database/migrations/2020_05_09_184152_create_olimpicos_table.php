<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOlimpicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olimpicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('avatar');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('olimpico_id');
            $table->text('text');
            $table->text('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('olimpico_id')->references('id')->on('olimpicos')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('olimpico_id');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('olimpico_id')->references('id')->on('olimpicos')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('olimpico_id');
            $table->text('text');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('olimpico_id')->references('id')->on('olimpicos')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::create('amistad', function (Blueprint $table) {
            $table->unsignedInteger('olimpico_id');
            $table->unsignedInteger('relacion_id');
            $table->string('type');
            $table->foreign('olimpico_id')->references('id')->on('olimpicos')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('relacion_id')->references('id')->on('olimpicos')
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
        Schema::dropIfExists('olimpicos');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
    }
}
