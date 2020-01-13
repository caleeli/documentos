<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AgregarModulosAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('modules')
            ->insert([
                ['parent' => 0, 'id' => 1100, 'name' => 'Administración', 'icon' => '/images/carpetas.svg', 'description' => 'Administración del sistema.', 'route' => '/?item=1100'],
            ]);
        DB::table('modules')
            ->insert([
                ['parent' => 1100, 'id'=> '1101', 'name' => 'Usuarios', 'icon' => '/images/carpeta.svg', 'description' => 'Usuarios del sistema', 'route' => '/admin/usuarios'],
                ['parent' => 1100, 'id'=> '1102', 'name' => 'Clasificadores principales', 'icon' => '/images/reporte-comunicacion.svg', 'description' => 'Clasificadores nivel 1', 'route' => '/admin/clasificacion'],
                ['parent' => 1100, 'id'=> '1103', 'name' => 'Clasificadores secundarios', 'icon' => '/images/reporte-informes.svg', 'description' => 'Clasificadores nivel 2', 'route' => '/admin/subclasificacion'],
                ['parent' => 1100, 'id'=> '1104', 'name' => 'Configuración', 'icon' => '/images/design.svg', 'description' => 'Configuración', 'route' => '/admin/sistema'],
            ]);
        DB::table('menu')
            ->insert([
                ['parent' => 0, 'id' => 1100, 'name' => 'Administración', 'route' => '#'],
            ]);
        DB::table('menu')
            ->insert([
                ['parent' => 1100, 'id'=> '1101', 'name' => 'Usuarios', 'route' => '/admin/usuarios'],
                ['parent' => 1100, 'id'=> '1102', 'name' => 'Clasificadores N1', 'route' => '/admin/clasificacion'],
                ['parent' => 1100, 'id'=> '1103', 'name' => 'Clasificadores N2', 'route' => '/admin/subclasificacion'],
                ['parent' => 1100, 'id'=> '1104', 'name' => 'Configuración', 'route' => '/admin/sistema'],
            ]);
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
