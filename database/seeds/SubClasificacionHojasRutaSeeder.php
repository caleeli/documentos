<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubClasificacionHojasRutaSeeder extends Seeder
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
        DB::table('hoja_ruta_sub_clases')
            ->insert([
                ['sub_clase_id' => '1.1', 'clasificacion_id' => '1', 'nombre' => '1.1 Procesos'],
                ['sub_clase_id' => '1.2', 'clasificacion_id' => '1', 'nombre' => '1.2 contratos'],
                ['sub_clase_id' => '1.3', 'clasificacion_id' => '1', 'nombre' => '1.3 Asignación de Usuarios'],
                ['sub_clase_id' => '1.4', 'clasificacion_id' => '1', 'nombre' => '1.4 Desconsolidaciones'],
                ['sub_clase_id' => '1.5', 'clasificacion_id' => '1', 'nombre' => '1.5 Bajas en Sistema'],
                ['sub_clase_id' => '1.6', 'clasificacion_id' => '1', 'nombre' => '1.6 Consultas Externas e Internas'],
                ['sub_clase_id' => '1.7', 'clasificacion_id' => '1', 'nombre' => '1.7 Elaboración de Solvencias'],
                ['sub_clase_id' => '1.8', 'clasificacion_id' => '1', 'nombre' => '1.8 Recepción DJBR'],
                ['sub_clase_id' => '1.9', 'clasificacion_id' => '1', 'nombre' => '1.9 Baja DJBR'],
                ['sub_clase_id' => '1.10', 'clasificacion_id' => '1', 'nombre' => '1.10 Solicitud de Información y Legalización DJBR'],
                ['sub_clase_id' => '1.11', 'clasificacion_id' => '1', 'nombre' => '1.11 Otros'],
                ['sub_clase_id' => '2.1', 'clasificacion_id' => '2', 'nombre' => '2.1 Solicitud de opinión legal por parte de otras Subcontralorias o Areas de la CGE'],
                ['sub_clase_id' => '2.2', 'clasificacion_id' => '2', 'nombre' => '2.2 Solicitud de Apoyo Legal Informes de Auditoria Externa'],
                ['sub_clase_id' => '2.3', 'clasificacion_id' => '2', 'nombre' => '2.3 Solicitud de Opinion Legal Informes Ciscunstanciados'],
                ['sub_clase_id' => '2.4', 'clasificacion_id' => '2', 'nombre' => '2.4 Evaluación Legal de Informes de Auditoria Interna'],                
                ['sub_clase_id' => '2.5', 'clasificacion_id' => '2', 'nombre' => '2.5 Inspección Legal Informes de Auditoria Externa'],                
                ['sub_clase_id' => '2.6', 'clasificacion_id' => '2', 'nombre' => '2.6 Revisión Legal Informes Ciscunstanciados'],                
                ['sub_clase_id' => '2.7', 'clasificacion_id' => '2', 'nombre' => '2.7 Inspección Legal Evaluación Legal Informes de Auditoria Interna'],                
                ['sub_clase_id' => '2.8', 'clasificacion_id' => '2', 'nombre' => '2.8 Respuesta Consultas Externas'],                
                ['sub_clase_id' => '2.9', 'clasificacion_id' => '2', 'nombre' => '2.9 Emisión de Opinión Legal consultas Internas'],                
                ['sub_clase_id' => '2.10', 'clasificacion_id' => '2', 'nombre' => '2.10 Auditorias Especiales realizadas por la SCSL'],                
                ['sub_clase_id' => '2.11', 'clasificacion_id' => '2', 'nombre' => '2.11 Informes Ciscunstanciados elaborados por la SCSL'],                
                ['sub_clase_id' => '2.12', 'clasificacion_id' => '2', 'nombre' => '2.12 Informes de Supervisión elaborados por la SCSL'],                
                ['sub_clase_id' => '2.13', 'clasificacion_id' => '2', 'nombre' => '2.13 Revisión de Proyectos Normativos'],                
                ['sub_clase_id' => '2.14', 'clasificacion_id' => '2', 'nombre' => '2.14 Elaboración de Proyectos de Resolución'], 
                ['sub_clase_id' => '2.15', 'clasificacion_id' => '2', 'nombre' => '2.15 Elaboración de Informes'],                
                ['sub_clase_id' => '2.16', 'clasificacion_id' => '2', 'nombre' => '2.16 Elaboración de Memoriales'],           
                ['sub_clase_id' => '2.17', 'clasificacion_id' => '2', 'nombre' => '2.17 Otros'], 
                ['sub_clase_id' => '3.1', 'clasificacion_id' => '3', 'nombre' => '3.1 Baja de Registro de Procesos'], 
                ['sub_clase_id' => '3.2', 'clasificacion_id' => '3', 'nombre' => '3.2 Exclusión de registro de procesos'], 
                ['sub_clase_id' => '3.3', 'clasificacion_id' => '3', 'nombre' => '3.3 Contrataciones por excepción, directas u otra norma expresa'], 
                ['sub_clase_id' => '3.4', 'clasificacion_id' => '3', 'nombre' => '3.4 Disposición de bienes'], 
                ['sub_clase_id' => '3.5', 'clasificacion_id' => '3', 'nombre' => '3.5 Otras Consultas externas'], 
                ['sub_clase_id' => '3.6', 'clasificacion_id' => '3', 'nombre' => '3.6 Apoyo Administrativo interno'], 
                ['sub_clase_id' => '3.7', 'clasificacion_id' => '3', 'nombre' => '3.7 Contratos'], 
                ['sub_clase_id' => '3.8', 'clasificacion_id' => '3', 'nombre' => '3.8 Normatividad'], 
                ['sub_clase_id' => '3.9', 'clasificacion_id' => '3', 'nombre' => '3.9 Otros']
        ]);
    }

    private function onlyOnce()
    {
        return DB::table('hoja_ruta_sub_clases')
                ->where('sub_clase_id', '1.1')
                ->first();
    }
}
