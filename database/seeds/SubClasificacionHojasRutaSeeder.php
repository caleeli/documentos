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
                ['sub_clase_id' => '1.1', 'clasificacion_id' => '1', 'nombre' => '1.1 Procesos'],
                ['sub_clase_id' => '1.2', 'clasificacion_id' => '1', 'nombre' => '1.2 contratos'],
                ['sub_clase_id' => '1.3', 'clasificacion_id' => '1', 'nombre' => '1.3 Asignación de Usuarios'],
                ['sub_clase_id' => '1.4', 'clasificacion_id' => '1', 'nombre' => '1.4 Desconsolidaciones'],
                ['sub_clase_id' => '1.5', 'clasificacion_id' => '1', 'nombre' => '1.5 Bajas en Sistema'],
                ['sub_clase_id' => '1.6', 'clasificacion_id' => '1', 'nombre' => '1.6 Consultas Externas e Internas'],
                ['sub_clase_id' => '1.7', 'clasificacion_id' => '1', 'nombre' => '1.7 Elaboración de Solvencias'],
                ['sub_clase_id' => '1.8', 'clasificacion_id' => '1', 'nombre' => '1.8 Recepción DJBR'],
                ['sub_clase_id' => '1.9', 'clasificacion_id' => '1', 'nombre' => '1.9 Baja DJBR'],
                ['sub_clase_id' => '1.10', 'clasificacion_id' => '1', 'nombre' => '1.10 Solicitud de Información y Legalización DJBR'],
                ['sub_clase_id' => '1.11', 'clasificacion_id' => '1', 'nombre' => '1.11 Otros']
        ]);
    }

    private function onlyOnce()
    {
        return DB::table('hoja_ruta_sub_clases')
                ->where('sub_clase_id', '1.1')
                ->first();
    }
}
