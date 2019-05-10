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
        DB::connection('hr')
            ->table('modules')
            ->insert([
                ['parent' => 0, 'id' => 100, 'name' => 'Hoja de Ruta Externa', 'icon' => '/images/hoja-de-ruta.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=100'],
                ['parent' => 100, 'id' => null, 'name' => 'Registrar', 'icon' => '/images/hoja-de-ruta.svg', 'description' => 'Hoja de ruta externa', 'route' => '/HojaRuta/externa/create'],
                ['parent' => 100, 'id' => null, 'name' => 'Busqueda', 'icon' => '/images/busqueda.svg', 'description' => 'Hoja de ruta externa', 'route' => '/HojaRutaBusqueda/externa'],
                ['parent' => 0, 'id' => 200, 'name' => 'Hoja de Ruta Interna', 'icon' => '/images/hoja-de-ruta-interna.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=200'],
                ['parent' => 200, 'id' => null, 'name' => 'Registrar', 'icon' => '/images/hoja-de-ruta-interna.svg', 'description' => 'Hoja de ruta interna', 'route' => '/HojaRuta/interna/create'],
                ['parent' => 200, 'id' => null, 'name' => 'Busqueda', 'icon' => '/images/busqueda-interna.svg', 'description' => 'Hoja de ruta interna', 'route' => '/HojaRutaBusqueda/interna'],
                ['parent' => 0, 'id' => 300, 'name' => 'Solicitudes y denuncia', 'icon' => '/images/hoja-de-ruta-solicitud.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=300'],
                ['parent' => 300, 'id' => null, 'name' => 'Registrar', 'icon' => '/images/hoja-de-ruta-solicitud.svg', 'description' => 'Solicitudes y denuncia', 'route' => '/HojaRuta/solicitud/create'],
                ['parent' => 300, 'id' => null, 'name' => 'Busqueda', 'icon' => '/images/busqueda-solicitud.svg', 'description' => 'Solicitudes y denuncia', 'route' => '/HojaRutaBusqueda/solicitud'],
                ['parent' => 0, 'id' => 400, 'name' => 'Notas oficio', 'icon' => '/images/nota-oficio.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=400'],
                ['parent' => 400, 'id' => null, 'name' => 'Registrar', 'icon' => '/images/nota-oficio.svg', 'description' => 'Notas oficio', 'route' => '/NotaOficio/notas'],
                ['parent' => 400, 'id' => null, 'name' => 'Busqueda', 'icon' => '/images/busqueda-nota-oficio.svg', 'description' => 'Notas oficio', 'route' => '/NotaOficioBusqueda/notas'],
                ['parent' => 0, 'id' => 500, 'name' => 'Informes', 'icon' => '/images/informes.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=500'],
                ['parent' => 500, 'id' => null, 'name' => 'Registrar', 'icon' => '/images/informes.svg', 'description' => 'Informes', 'route' => '/ComunicacionesInternas/informes'],
                ['parent' => 500, 'id' => null, 'name' => 'Busqueda', 'icon' => '/images/busqueda-informes.svg', 'description' => 'Informes', 'route' => '/NotaOficioBusqueda/informes'],
                ['parent' => 0, 'id' => 600, 'name' => 'Comunicaciónes internas', 'icon' => '/images/comunicacion.svg', 'description' => 'Registro busqueda y reporte', 'route' => '/?item=600'],
                ['parent' => 600, 'id' => null, 'name' => 'Registrar', 'icon' => '/images/comunicacion.svg', 'description' => 'Comunicaciónes internas', 'route' => '/ComunicacionesInternas/comunicacion'],
                ['parent' => 600, 'id' => null, 'name' => 'Busqueda', 'icon' => '/images/busqueda-comunicacion.svg', 'description' => 'Comunicaciónes internas', 'route' => '/NotaOficioBusqueda/comunicacion'],
                ['parent' => 0, 'id' => 700, 'name' => 'Reporte', 'icon' => '/images/reporte.svg', 'description' => 'Reportes de hojas de ruta, notas, etc.', 'route' => '/HojaRutaReporte/externa'],
                ['parent' => 0, 'id' => 800, 'name' => 'Reporte Resumen', 'icon' => '/images/reporte-resumen.svg', 'description' => 'Resumen del reporte de hojas de ruta.', 'route' => '/HojaRutaReporteRapido'],
        ]);
    }

    private function onlyOnce()
    {
        return DB::connection('hr')
                ->table('modules')
                ->where('route', '/?item=100')
                ->first();
    }
}
