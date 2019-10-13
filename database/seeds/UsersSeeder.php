<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_roles')->insert([
            'name' => 'admin',
            'status' => 'ACTIVE',
        ]);
        DB::table('adm_users')->insert([
            'nombres' => 'Admin',
            'apellidos' => 'Admin',
            'username' => 'admin',
            'password' => md5('administrador'),
            'numero_ci' => 123456,
            'tipo_doc_ci' => 1,
            'role_id' => 1,
            'email' => 'admin@scsl.gob.bo',
            'api_token' => md5('default_session'),
            'reservado' => true,
        ]);
        DB::table('adm_users')->insert([
            'nombres' => 'ARCHIVO',
            'apellidos' => '',
            'username' => 'archivo',
            'password' => md5('administrador'),
            'numero_ci' => 654321,
            'tipo_doc_ci' => 1,
            'role_id' => 1,
            'email' => 'archivo@scsl.gob.bo',
            'api_token' => md5('default_session'),
            'reservado' => true,
        ]);
        $pdo = DB::getPdo();
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 0);
        $pdo->exec(file_get_contents(__DIR__ . '/Users.sql'));
    }
}
