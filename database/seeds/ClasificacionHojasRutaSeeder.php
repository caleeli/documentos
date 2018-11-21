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
        DB::connection('hr')
            ->table('hoja_ruta_clasificacion')
            ->insert([
                ['sigla' => 'EDC', 'nombre' => '1. Evaluación de Consistencia'],
                ['sigla' => 'AUD', 'nombre' => '2. Auditorías'],
                ['sigla' => 'SUP', 'nombre' => '3. Supervisiones'],
                ['sigla' => 'COD', 'nombre' => '4. Contrataciones Directas'],
                ['sigla' => 'EIU', 'nombre' => '5. Evaluación de Informes UAI\'s'],
                ['sigla' => 'EIP', 'nombre' => '6. Evaluación de Informes POA y PE de las UAI\'s'],
                ['sigla' => 'IAU', 'nombre' => '7. Informes de Actividades UAI\'s'],
                ['sigla' => 'SYD', 'nombre' => '8. Solicitudes y Denuncias'],
                ['sigla' => 'TAD', 'nombre' => '9. Tareas Administrativas'],
                ['sigla' => 'ASS', 'nombre' => '10. Alimentación del Sistema subcep.com'],
        ]);
    }
}
