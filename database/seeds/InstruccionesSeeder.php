<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstruccionesSeeder extends Seeder
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
        DB::table('instrucciones')
            ->insert([
                ['sigla' => 'SCSL-UR', 'nombre' => '1. Verificar'],
                ['sigla' => 'SCSL-UR', 'nombre' => '2. Subsanar'],
                ['sigla' => 'SCSL-UR', 'nombre' => '3. Remitir a la Entidad'],
                ['sigla' => 'SCSL-UR', 'nombre' => '4. Asignar'],
                ['sigla' => 'SCSL-UR', 'nombre' => '5. Preparar Respuesta'],
                ['sigla' => 'SCSL-UR', 'nombre' => '6. Ejecutar'],
                ['sigla' => 'SCSL-UR', 'nombre' => '7. No corresponde'],
                ['sigla' => 'SCSL-UR', 'nombre' => '8. Archivar'],
                ['sigla' => 'SCSL-GSL', 'nombre' => '1. Designación'],
                ['sigla' => 'SCSL-GSL', 'nombre' => '2. Asistir'],
                ['sigla' => 'SCSL-GSL', 'nombre' => '3. Revisar'],
                ['sigla' => 'SCSL-GSL', 'nombre' => '4. Otros'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '1. Asignación para análisis'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '2. Control de calidad'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '3. Instruir la Baja del sistema'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '4. Se pone en conocimiento del solicitante exclusión del sistema'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '5. Solicitud de mayor información'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '6. Remitir a la GPA'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '7. Respuesta'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '7. Respuesta'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '8. Remisión donde corresponda'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '9. Elaborar normatividad en limpio'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '10. Remitir para aprobación'],
                ['sigla' => 'SCSL-GAAJ', 'nombre' => '11. Archivo'],
        ]);
    }

    private function onlyOnce()
    {
        return DB::table('instrucciones')
                ->where('nombre', '1. Aprovar')
                ->first();
    }
}
