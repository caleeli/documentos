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
                ['sigla' => '1', 'nombre' => '1. Aprovar'],
                ['sigla' => '2', 'nombre' => '2. Revisar'],
                ['sigla' => '3', 'nombre' => '3. Justificar'],
                ['sigla' => '4', 'nombre' => '4. Su opinión'],
                ['sigla' => '5', 'nombre' => '5. Coordinar'],
                ['sigla' => '6', 'nombre' => '6. Para archivo'],
                ['sigla' => '7', 'nombre' => '7. Preparar respuesta'],
                ['sigla' => '8', 'nombre' => '8. Analizar'],
                ['sigla' => '9', 'nombre' => '9. Para su conocimiento'],
                ['sigla' => '10', 'nombre' => '10. Visiteme'],
                ['sigla' => '11', 'nombre' => '11. Evaluar'],
                ['sigla' => '12', 'nombre' => '12. Justificar'],
        ]);
    }

    private function onlyOnce()
    {
        return DB::table('instrucciones')
                ->where('nombre', '1. Aprovar')
                ->first();
    }
}
