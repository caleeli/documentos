<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubClasificacionHojasRutaSeeder extends Seeder
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
        DB::table('hoja_ruta_sub_clases')
            ->insert([
                ['sub_clase_id' => '1.1', 'clasificacion_id' => '1', 'nombre' => '1.1 Dictamen e informes de Firmas de Auditoria y/o Empresa Pública'],
                ['sub_clase_id' => '1.2', 'clasificacion_id' => '1', 'nombre' => '1.2 Documentación de proceso de contratación de Firmas de auditoria y/o Empresa Pública'],
                ['sub_clase_id' => '1.3', 'clasificacion_id' => '1', 'nombre' => '1.3 Papeles de trabajo de Firmas de Auditoria'],
                ['sub_clase_id' => '1.4', 'clasificacion_id' => '1', 'nombre' => '1.4 Formato 1 y 2'],
        ]);
    }

    private function onlyOnce()
    {
        return DB::table('hoja_ruta_sub_clases')
                ->where('sub_clase_id', '1.1')
                ->first();
    }
}
