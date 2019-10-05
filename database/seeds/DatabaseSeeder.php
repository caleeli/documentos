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
        $this->call(UsersSeeder::class);
        $this->call(ClasificacionHojasRutaSeeder::class);
        $this->call(InstruccionesSeeder::class);
        $this->call(SubClasificacionHojasRutaSeeder::class);
        $this->call(LoadDefaultMenus::class);
        $this->call(LoadDefaultModules::class);
        $this->call(EmpresasSeeder::class);
        $this->call(TareasEjemploSeeder::class);
    }
}
