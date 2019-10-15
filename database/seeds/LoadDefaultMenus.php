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
        DB::table('menu')
            ->insert([
                ['parent' => 0, 'id' => 100, 'name' => 'Hoja de Ruta', 'route' => '#'],
                ['parent' => 0, 'id' => 400, 'name' => 'Notas oficio', 'route' => '#'],
                ['parent' => 0, 'id' => 500, 'name' => 'Informes', 'route' => '#'],
                ['parent' => 0, 'id' => 600, 'name' => 'Comunicaciones internas', 'route' => '#'],
                ['parent' => 0, 'id' => 700, 'name' => 'Reporte', 'route' => '/HojaRutaReporte/interna'],
                ['parent' => 0, 'id' => 900, 'name' => 'Seguimiento', 'route' => '/Seguimiento'],
            ]);
        DB::table('menu')
            ->insert([
                ['parent' => 100, 'name' => 'Registrar', 'route' => '/HojaRuta/create'],
                ['parent' => 100, 'name' => 'Búsqueda', 'route' => '/HojaRutaBusqueda'],
                ['parent' => 400, 'name' => 'Registrar', 'route' => '/NotaOficio/notas'],
                ['parent' => 400, 'name' => 'Búsqueda', 'route' => '/NotaOficioBusqueda/notas'],
                ['parent' => 500, 'name' => 'Registrar', 'route' => '/Informe/create'],
                ['parent' => 500, 'name' => 'Búsqueda', 'route' => '/InformeBusqueda/informes'],
                ['parent' => 600, 'name' => 'Registrar', 'route' => '/ComunicacionesInternas/comunicacion'],
                ['parent' => 600, 'name' => 'Búsqueda', 'route' => '/NotaOficioBusqueda/comunicacion'],
            ]);
    }

    private function onlyOnce()
    {
        return DB::table('menu')
                ->where('route', '/HojaRuta/externa/create')
                ->first();
    }
}
