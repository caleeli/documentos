<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoadDefaultModules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->onlyOnce()) {
            return;
        }
        DB::table('modules')
            ->insert([
                ['parent' => 0, 'id' => 100, 'name' => 'Hoja de Ruta', 'icon' => '/images/hoja-de-ruta.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=100'],
                /*['parent' => 0, 'id' => 200, 'name' => 'Hoja de Ruta Interna', 'icon' => '/images/hoja-de-ruta-interna.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=200'],
                ['parent' => 0, 'id' => 300, 'name' => 'Solicitudes y denuncia', 'icon' => '/images/hoja-de-ruta-solicitud.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=300'],*/
                ['parent' => 0, 'id' => 400, 'name' => 'Notas oficio', 'icon' => '/images/nota-oficio.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=400'],
                ['parent' => 0, 'id' => 500, 'name' => 'Informes', 'icon' => '/images/informes.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=500'],
                ['parent' => 0, 'id' => 600, 'name' => 'Comunicaciónes internas', 'icon' => '/images/comunicacion.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=600'],
                ['parent' => 0, 'id' => 700, 'name' => 'Reporte', 'icon' => '/images/reporte.svg', 'description' => 'Reportes de hojas de ruta, notas, etc.', 'route' => '/HojaRutaReporte/externa'],
                //['parent' => 0, 'id' => 800, 'name' => 'Reporte Resumen', 'icon' => '/images/reporte-resumen.svg', 'description' => 'Resumen del reporte de hojas de ruta.', 'route' => '/HojaRutaReporteRapido'],
                ['parent' => 0, 'id' => 900, 'name' => 'Seguimiento', 'icon' => '/images/seguimiento.svg', 'description' => 'Seguimiento de tareas.', 'route' => '/Seguimiento'],
                ['parent' => 0, 'id' => 1000, 'name' => 'Cambiar contraseña', 'icon' => '/images/password.svg', 'description' => 'Cambiar contraseña de ingreso al sistema.', 'route' => '/cambiar_password'],
                ['parent' => 0, 'id' => 1100, 'name' => 'Administración', 'icon' => '/images/carpetas.svg', 'description' => 'Administración del sistema.', 'route' => '/?item=1100'],
            ]);
        DB::table('modules')
            ->insert([
                ['parent' => 100, 'name' => 'Registrar', 'icon' => '/images/hoja-de-ruta.svg', 'description' => 'Hoja de ruta', 'route' => '/HojaRuta/create'],
                ['parent' => 100, 'name' => 'Busqueda', 'icon' => '/images/busqueda.svg', 'description' => 'Hoja de ruta', 'route' => '/HojaRutaBusqueda'],
                ['parent' => 400, 'name' => 'Registrar', 'icon' => '/images/nota-oficio.svg', 'description' => 'Notas oficio', 'route' => '/NotaOficio/notas'],
                ['parent' => 400, 'name' => 'Busqueda', 'icon' => '/images/busqueda-nota-oficio.svg', 'description' => 'Notas oficio', 'route' => '/NotaOficioBusqueda/notas'],
                ['parent' => 500, 'name' => 'Registrar', 'icon' => '/images/informes.svg', 'description' => 'Informes', 'route' => '/Informe/create'],
                ['parent' => 500, 'name' => 'Busqueda', 'icon' => '/images/busqueda-informes.svg', 'description' => 'Informes', 'route' => '/InformeBusqueda/informes'],
                ['parent' => 600, 'name' => 'Registrar', 'icon' => '/images/comunicacion.svg', 'description' => 'Comunicaciónes internas', 'route' => '/ComunicacionesInternas/comunicacion'],
                ['parent' => 600, 'name' => 'Busqueda', 'icon' => '/images/busqueda-comunicacion.svg', 'description' => 'Comunicaciónes internas', 'route' => '/NotaOficioBusqueda/comunicacion'],
                ['parent' => 1100, 'id'=> '1101', 'name' => 'Usuarios', 'icon' => '/images/carpeta.svg', 'description' => 'Usuarios del sistema', 'route' => '/admin/usuarios'],
                ['parent' => 1100, 'id'=> '1102', 'name' => 'Clasificadores principales', 'icon' => '/images/reporte-comunicacion.svg', 'description' => 'Clasificadores nivel 1', 'route' => '/admin/clasificacion'],
                ['parent' => 1100, 'id'=> '1103', 'name' => 'Clasificadores secundarios', 'icon' => '/images/reporte-informes.svg', 'description' => 'Clasificadores nivel 2', 'route' => '/admin/subclasificacion'],
                ['parent' => 1100, 'id'=> '1104', 'name' => 'Configuración', 'icon' => '/images/design.svg', 'description' => 'Configuración', 'route' => '/admin/sistema'],
            ]);
    }

    private function onlyOnce()
    {
        return DB::table('modules')
                ->where('route', '/?item=100')
                ->first();
    }
}
