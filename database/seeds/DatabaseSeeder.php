<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClasificacionHojasRutaSeeder::class);
        $this->call(InstruccionesSeeder::class);
        $this->call(SubClasificacionHojasRutaSeeder::class);
    }
}
