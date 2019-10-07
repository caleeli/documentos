<?php

use App\Tarea;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TareasEjemploSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Tarea::insert([
            'tar_codigo' => 'SCSL-12',
            'tar_descripcion' => 'Remite informe de Auditoria Externa de la Firma ZABALA AUDITORES Y CONSULTORES S.R.L.',
            'tar_fecha_derivacion' => new Carbon(),
            'tar_fecha_fin' => null,
            'tar_estado' => 'Pendiente',
            'tar_avance' => 30,
            'tar_prioridad' => 1,
            'tar_comentarios' => '<p>Ejemplo de <u>comentarios</u></p>',
        ]);*/
        factory(Tarea::class)->create();
    }
}
