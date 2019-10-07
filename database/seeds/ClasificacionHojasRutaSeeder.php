<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionHojasRutaSeeder extends Seeder
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
        DB::table('hoja_ruta_clasificacion')
            ->insert([
                ['sigla' => 'EDC', 'nombre' => '1. Unidad de Registro y DJBR'],
                ['sigla' => 'AUD', 'nombre' => '2. Gerencia de Servicios Legales'],
                ['sigla' => 'SUP', 'nombre' => '3. Gerencia de Asuntos Administrativos y Jurídica']
        ]);
    }

    private function onlyOnce()
    {
        return DB::table('hoja_ruta_clasificacion')
                ->where('nombre', '1. Procesos)
                ->first();
    }
}
