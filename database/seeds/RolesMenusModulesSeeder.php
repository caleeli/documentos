<?php

use App\Menu;
use App\Module;
use Illuminate\Database\Seeder;

class RolesMenusModulesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = Menu::find(1); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //1	Registrar	/HojaRuta/create
        $row = Menu::find(2); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //2	Búsqueda	/HojaRutaBusqueda
        $row = Menu::find(3); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //3	Registrar	/NotaOficio/notas
        $row = Menu::find(4); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //4	Búsqueda	/NotaOficioBusqueda/notas
        $row = Menu::find(5); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //5	Registrar	/Informe/create
        $row = Menu::find(6); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //6	Búsqueda	/InformeBusqueda/informes
        $row = Menu::find(7); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //7	Registrar	/ComunicacionesInternas/comunicacion
        $row = Menu::find(8); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //8	Búsqueda	/NotaOficioBusqueda/comunicacion
        $row = Menu::find(100); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 100	Hoja de Ruta	#
        $row = Menu::find(400); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 400	Notas oficio	#
        $row = Menu::find(500); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 500	Informes	#
        $row = Menu::find(600); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 600	Comunicaciones internas	#
        $row = Menu::find(700); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 700	Reporte	/HojaRutaReporte/interna
        $row = Menu::find(900); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 900	Seguimiento	/Seguimiento
        $row = Menu::find(1100); $row->roles = ['enabled' => [1,]]; $row->save();       // 1100	Administración	#
        $row = Menu::find(1101); $row->roles = ['enabled' => [1,]]; $row->save();       // 1101	Usuarios	/admin/usuarios
        $row = Menu::find(1102); $row->roles = ['enabled' => [1,]]; $row->save();       // 1102	Clasificadores N1	/admin/clasificacion
        $row = Menu::find(1103); $row->roles = ['enabled' => [1,]]; $row->save();       // 1103	Clasificadores N2	/admin/subclasificacion
        $row = Menu::find(1104); $row->roles = ['enabled' => [1,]]; $row->save();       // 1104	Configuración	/admin/sistema

        $row = Module::find(1); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //1	Registrar	/HojaRuta/create
        $row = Module::find(2); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //2	Búsqueda	/HojaRutaBusqueda
        $row = Module::find(3); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //3	Registrar	/NotaOficio/notas
        $row = Module::find(4); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //4	Búsqueda	/NotaOficioBusqueda/notas
        $row = Module::find(5); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //5	Registrar	/Informe/create
        $row = Module::find(6); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //6	Búsqueda	/InformeBusqueda/informes
        $row = Module::find(7); $row->roles = ['enabled' => [1,2,4]]; $row->save();     //7	Registrar	/ComunicacionesInternas/comunicacion
        $row = Module::find(8); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();     //8	Búsqueda	/NotaOficioBusqueda/comunicacion
        $row = Module::find(100); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 100	Hoja de Ruta	#
        $row = Module::find(400); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 400	Notas oficio	#
        $row = Module::find(500); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 500	Informes	#
        $row = Module::find(600); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 600	Comunicaciones internas	#
        $row = Module::find(700); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 700	Reporte	/HojaRutaReporte/interna
        $row = Module::find(900); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();       // 900	Seguimiento	/Seguimiento
        $row = Module::find(1000); $row->roles = ['enabled' => [1,2,3,4]]; $row->save();      // 1000	Cambiar contraseña	/cambiar_password
        $row = Module::find(1100); $row->roles = ['enabled' => [1,]]; $row->save();       // 1100	Administración	#
        $row = Module::find(1101); $row->roles = ['enabled' => [1,]]; $row->save();       // 1101	Usuarios	/admin/usuarios
        $row = Module::find(1102); $row->roles = ['enabled' => [1,]]; $row->save();       // 1102	Clasificadores N1	/admin/clasificacion
        $row = Module::find(1103); $row->roles = ['enabled' => [1,]]; $row->save();       // 1103	Clasificadores N2	/admin/subclasificacion
        $row = Module::find(1104); $row->roles = ['enabled' => [1,]]; $row->save();       // 1104	Configuración	/admin/sistema
    }
}
