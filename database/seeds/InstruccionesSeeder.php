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
                ['sigla' => 'UR', 'nombre' => '1. Verificar'],
                ['sigla' => 'UR', 'nombre' => '2. Subsanar'],
                ['sigla' => 'UR', 'nombre' => '3. Remitir a la Entidad'],
                ['sigla' => 'UR', 'nombre' => '4. Asignar'],
                ['sigla' => 'UR', 'nombre' => '5. Preparar Respuesta'],
                ['sigla' => 'UR', 'nombre' => '6. Ejecutar'],
                ['sigla' => 'UR', 'nombre' => '7. No corresponde'],
                ['sigla' => 'UR', 'nombre' => '8. Archivar'],
                ['sigla' => 'GSL', 'nombre' => '1. Designación'],
                ['sigla' => 'GSL', 'nombre' => '2. Asistir'],
                ['sigla' => 'GSL', 'nombre' => '3. Revisar'],
                ['sigla' => 'GSL', 'nombre' => '4. Otros'],
                ['sigla' => 'GAAJ', 'nombre' => '1. Asignación para análisis'],
                ['sigla' => 'GAAJ', 'nombre' => '2. Control de calidad'],
                ['sigla' => 'GAAJ', 'nombre' => '3. Instruir la Baja del sistema'],
                ['sigla' => 'GAAJ', 'nombre' => '4. Se pone en conocimiento del solicitante exclusión del sistema'],
                ['sigla' => 'GAAJ', 'nombre' => '5. Solicitud de mayor información'],
                ['sigla' => 'GAAJ', 'nombre' => '6. Remitir a la GPA'],
                ['sigla' => 'GAAJ', 'nombre' => '7. Respuesta'],
                ['sigla' => 'GAAJ', 'nombre' => '7. Respuesta'],
                ['sigla' => 'GAAJ', 'nombre' => '8. Remisión donde corresponda'],
                ['sigla' => 'GAAJ', 'nombre' => '9. Elaborar normatividad en limpio'],
                ['sigla' => 'GAAJ', 'nombre' => '10. Remitir para aprobación'],
                ['sigla' => 'GAAJ', 'nombre' => '11. Archivo'],
        ]);
    }

    private function onlyOnce()
    {
        return DB::table('instrucciones')
                ->where('nombre', '1. Aprovar')
                ->first();
    }
}
