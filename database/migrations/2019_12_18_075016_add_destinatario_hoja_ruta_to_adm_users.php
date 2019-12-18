<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDestinatarioHojaRutaToAdmUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adm_users', function (Blueprint $table) {
            $table->boolean('destinatario_hoja_ruta')->default(false);
        });
        if ($user = User::where('username', 'eclavijo')->first()) {
            $user->destinatario_hoja_ruta = 1;
            $user->save();
        }
        if ($user = User::where('username', 'cmendieta')->first()) {
            $user->destinatario_hoja_ruta = 1;
            $user->save();
        }
        if ($user = User::where('username', 'rduarte')->first()) {
            $user->destinatario_hoja_ruta = 1;
            $user->save();
        }
        if ($user = User::where('username', 'kguibarra')->first()) {
            $user->destinatario_hoja_ruta = 1;
            $user->save();
        }
        if ($user = User::where('username', 'gpizarroso')->first()) {
            $user->destinatario_hoja_ruta = 1;
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adm_users', function (Blueprint $table) {
            $table->dropColumn(['destinatario_hoja_ruta']);
        });
    }
}
