<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateAdmEmpresaEstadosTable extends Migration
{
    public function up()
    {
        if (DB::connection()->getName() !== 'testing') {
            DB::statement('CREATE VIEW adm_empresa_estados AS select max(adm_estado_financieros.id) as id, adm_empresas.id as empresa_id, nombre_empresa, gestion from adm_estado_financieros left join adm_empresas on (adm_estado_financieros.empresa_id=adm_empresas.id) group by adm_empresas.id, gestion');
        }
    }

    public function down()
    {
        if (DB::connection()->getName() !== 'testing') {
            Schema::dropIfExists('adm_empresa_estados');
        }
    }
}
