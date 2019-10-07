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
        $tarea = factory(Tarea::class)->create();
        $tarea->usuarios()->sync([1]);
    }
}
