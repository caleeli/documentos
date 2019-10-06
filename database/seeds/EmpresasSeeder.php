<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_empresas')
            ->insert([
                ['cod_empresa' => '291', 'nombre_empresa' => 'Administradora Boliviana de Carreteras', 'sigla_empresa' => 'ABC'],
            ]);
        DB::insert(file_get_contents(__DIR__ . '/Entidades.sql'));
    }
}
