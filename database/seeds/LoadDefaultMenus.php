<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoadDefaultMenus extends Seeder
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
            ->table('menu')
            ->insert([
                ['parent' => 0, 'id' => 100, 'name' => 'Hoja de Ruta Externa', 'route' => '#'],
                ['parent' => 100, 'id' => null, 'name' => 'Registrar', 'route' => '/HojaRuta/externa/create'],
                ['parent' => 100, 'id' => null, 'name' => 'Búsqueda', 'route' => '/HojaRutaBusqueda/externa'],
                //['parent' => 1, 'name' => 'Reporte', 'route' => '/HojaRutaReporte/externa'],
                ['parent' => 0, 'id' => 200, 'name' => 'Hoja de Ruta Interna', 'route' => '#'],
                ['parent' => 200, 'id' => null, 'name' => 'Registrar', 'route' => '/HojaRuta/interna/create'],
                ['parent' => 200, 'id' => null, 'name' => 'Búsqueda', 'route' => '/HojaRutaBusqueda/interna'],
                ['parent' => 0, 'id' => 300, 'name' => 'Solicitudes y denuncia', 'route' => '#'],
                ['parent' => 300, 'id' => null, 'name' => 'Registrar', 'route' => '/HojaRuta/solicitud/create'],
                ['parent' => 300, 'id' => null, 'name' => 'Búsqueda', 'route' => '/HojaRutaBusqueda/solicitud'],
                ['parent' => 0, 'id' => 400, 'name' => 'Notas oficio', 'route' => '#'],
                ['parent' => 400, 'id' => null, 'name' => 'Registrar', 'route' => '/NotaOficio/notas'],
                ['parent' => 400, 'id' => null, 'name' => 'Búsqueda', 'route' => '/NotaOficioBusqueda/notas'],
                ['parent' => 0, 'id' => 500, 'name' => 'Informes', 'route' => '#'],
                ['parent' => 500, 'id' => null, 'name' => 'Registrar', 'route' => '/Informe/create'],
                ['parent' => 500, 'id' => null, 'name' => 'Búsqueda', 'route' => '/NotaOficioBusqueda/informes'],
                ['parent' => 0, 'id' => 600, 'name' => 'Comunicaciones internas', 'route' => '#'],
                ['parent' => 600, 'id' => null, 'name' => 'Registrar', 'route' => '/ComunicacionesInternas/comunicacion'],
                ['parent' => 600, 'id' => null, 'name' => 'Búsqueda', 'route' => '/NotaOficioBusqueda/comunicacion'],
                ['parent' => 0, 'id' => 700, 'name' => 'Reporte', 'route' => '/HojaRutaReporte/interna'],
        ]);
    }

    private function onlyOnce()
    {
        return DB::connection('hr')
                ->table('menu')
                ->where('route', '/HojaRuta/externa/create')
                ->first();
    }
}
