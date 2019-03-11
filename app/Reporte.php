<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Reporte
 *
 */
class Reporte extends Model
{

    //use AutoTableTrait;

    public $timestamps = false;
    protected $connection = 'hr';
    protected $table = 'reportes';
    protected $fillable = [
        'tipo',
        'recepcion_desde',
        'recepcion_hasta',
        'referencia',
        'procedencia',
        'nro_de_control',
        'conclusion_desde',
        'conclusion_hasta',
        'gestion_desde',
        'gestion_hasta',
        'destinatario',
        'tipo_tarea',
        'tipo_reporte',
    ];
    protected $casts = [
        'recepcion_desde' => 'date',
        'recepcion_hasta' => 'date',
        'conclusion_desde' => 'date',
        'conclusion_hasta' => 'date',
    ];

    /**
     * Reporte generado a partir de los parametros
     */
    public function generar1()
    {
        $connection = $this->getConnection()->getPdo();

        $query = [];
        $params = [];
        $addDerivacion = false;
        $query[] = ' hoja_ruta.tipo_hr = :tipo';
        $params['tipo'] = $this->tipo;
        if (!empty($this->recepcion_desde)) {
            $query[] = ' hoja_ruta.fecha >= :recepcion_desde';
            $params['recepcion_desde'] = $this->recepcion_desde->format('Y-m-d');
        }
        if (!empty($this->recepcion_hasta)) {
            $query[] = ' hoja_ruta.fecha <= :recepcion_hasta';
            $params['recepcion_hasta'] = $this->recepcion_hasta->format('Y-m-d');
        }
        if (!empty($this->referencia)) {
            $query[] = ' hoja_ruta.referencia like :referencia';
            $params['referencia'] = '%' . str_replace(' ', '%',
                    $this->referencia) . '%';
        }
        if (!empty($this->procedencia)) {
            $query[] = ' hoja_ruta.procedencia like :procedencia';
            $params['procedencia'] = '%' . str_replace(' ', '%',
                    $this->procedencia) . '%';
        }
        if (!empty($this->nro_de_control)) {
            $q = [];
            foreach (explode(',', $this->nro_de_control) as $nro) {
                $q[] = "hoja_ruta.nro_de_control REGEXP '[[:<:]]" . str_replace(['"', ' '],
                        "", $nro) . "[[:>:]]'";
            }
            $query[] = '(' . implode(' or ', $q) . ')';
        }
        if (!empty($this->conclusion_desde)) {
            $query[] = ' hoja_ruta.conclusion >= :conclusion_desde';
            $params['conclusion_desde'] = $this->conclusion_desde->format('Y-m-d');
        }
        if (!empty($this->conclusion_hasta)) {
            $query[] = ' hoja_ruta.conclusion <= :conclusion_hasta';
            $params['conclusion_hasta'] = $this->conclusion_hasta->format('Y-m-d');
        }
        if (!empty($this->gestion_desde)) {
            $query[] = ' hoja_ruta.gestion >= :gestion_desde';
            $params['gestion_desde'] = $this->gestion_desde;
        }
        if (!empty($this->gestion_hasta)) {
            $query[] = ' hoja_ruta.gestion <= :gestion_hasta';
            $params['gestion_hasta'] = $this->gestion_hasta;
        }
        /* if (!empty($this->fecha_derivacion1)) {
          $query[] = ' derivacion.fecha >= :fecha_derivacion1';
          $params['fecha_derivacion1'] = $this->fecha_derivacion1;
          $addDerivacion = true;
          }
          if (!empty($this->fecha_derivacion2)) {
          $query[] = ' derivacion.fecha <= :fecha_derivacion2';
          $params['fecha_derivacion2'] = $this->fecha_derivacion2;
          $addDerivacion = true;
          } */
        if (!empty($this->destinatario)) {
            $query[] = ' derivacion.destinatario like :destinatario';
            $params['destinatario'] = '%' . str_replace(' ', '%',
                    $this->destinatario) . '%';
            $addDerivacion = true;
        }
        if (!empty($this->tipo_tarea)) {
            $query[] = ' hoja_ruta.tipo_tarea = :tipo_tarea';
            $params['tipo_tarea'] = $this->tipo_tarea;
        }
        $addDerivacion = true;
        $select = 'hoja_ruta.*, derivacion.fecha as derivacion_fecha, derivacion.destinatario as derivacion_destinatario, derivacion.instruccion';

        //if ($this->todasLasDerivaciones === 'true') {
        if ($this->tipo_reporte === 'detallada') {
            $query = 'select ' . $select . ' from hoja_ruta '
                . ($addDerivacion ? 'left join derivacion on (derivacion.hoja_ruta_id=hoja_ruta.hr_scep_id) ' : '')
                . ($query ? 'where hoja_ruta.hr_scep_id in '
                . '(select hoja_ruta.hr_scep_id from hoja_ruta left join derivacion on (derivacion.hoja_ruta_id=hoja_ruta.hr_scep_id) where '
                . implode(' and ', $query) . ')' : '');
        } else {
            $esElUltimoDestinatario = 'derivacion.id = (select max(id) from derivacion d2 where d2.hoja_ruta_id=hoja_ruta.hr_scep_id)';
            $query = 'select ' . $select . ' from hoja_ruta '
                . ($addDerivacion ? 'left join derivacion on (derivacion.hoja_ruta_id=hoja_ruta.hr_scep_id and ' . $esElUltimoDestinatario . ') ' : '')
                . ($query ? ' where ' . implode(' and ', $query) : '');
        }

        $stmt = $connection->prepare($query);
        foreach ($params as $p) {
            if (is_array($p)) {
                $stmt->bindParam(":$p", $p, PDO::PA);
            } else {
                
            }
        }
        //$connection->que
        $stmt->execute($params);
        $res = [];
        $num = 1;
        $res2 = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $id = $row['hr_scep_id'];
            if (!isset($res[$id])) {
                $res[$id] = $row;
                $res[$id]['derivaciones'] = [];
            } else {
                $row = [
                    "fecha" => $row['derivacion_fecha'],
                    "destinatario" => $row['derivacion_destinatario'],
                    "num" => $num,
                ];
            }
            $num++;
            $res2[] = $row;
        }
        return $res2; //array_values($res);
    }

    public function getProcedencias()
    {
        $empresas = Empresa::get();
        $procedencias = [];
        foreach ($empresas as $empresa) {
            $procedencias[] = [
                'id' => $empresa->id,
                'attributes' => [
                    'nombre_completo' => $empresa->nombre_empresa,
                ]
            ];
        }
        return $procedencias;
    }

    public function generar()
    {
        $connection = $this->getConnection()->getPdo();
        $params = [];
        $query = ["SELECT
            derivacion.destinatario,
            concat(hoja_ruta.nro_de_control,' / ',hoja_ruta.gestion) numero,
            hoja_ruta.hr_scep_id,
            hoja_ruta.tipo_hr,
            hoja_ruta.referencia,
            hoja_ruta.procedencia,
            hoja_ruta.fecha_recepcion,
            hoja_ruta.fecha_conclusion,
            derivacion.fecha as derivacion_fecha,
            derivacion.instruccion,
            derivacion.comentarios
         FROM
           (select hoja_ruta_id, max(id) as id from derivacion group by hoja_ruta_id) ultimos
            inner join derivacion on (ultimos.id=derivacion.id)
            inner join hoja_ruta on (derivacion.hoja_ruta_id=hoja_ruta.hr_scep_id)
         WHERE 
            hoja_ruta.fecha_conclusion != '0000-00-00'
        "];
        $query[] = ' hoja_ruta.tipo_hr = :tipo';
        $params['tipo'] = $this->tipo;
        if (!empty($this->recepcion_desde)) {
            $query[] = ' hoja_ruta.fecha >= :recepcion_desde';
            $params['recepcion_desde'] = $this->recepcion_desde->format('Y-m-d');
        }
        if (!empty($this->recepcion_hasta)) {
            $query[] = ' hoja_ruta.fecha <= :recepcion_hasta';
            $params['recepcion_hasta'] = $this->recepcion_hasta->format('Y-m-d');
        }
        if (!empty($this->referencia)) {
            $query[] = ' hoja_ruta.referencia like :referencia';
            $params['referencia'] = '%' . str_replace(' ', '%',
                    $this->referencia) . '%';
        }
        if (!empty($this->procedencia)) {
            $query[] = ' hoja_ruta.procedencia like :procedencia';
            $params['procedencia'] = '%' . str_replace(' ', '%',
                    $this->procedencia) . '%';
        }
        if (!empty($this->nro_de_control)) {
            $q = [];
            $fields = [
                'hoja_ruta.nro_de_control',
                'hoja_ruta.referencia',
                'derivacion.comentarios',
            ];
            foreach ($fields as $field) {
                /* foreach (explode(',', $this->nro_de_control) as $nro) {
                  $q[] = "hoja_ruta.nro_de_control REGEXP '[[:<:]]" . str_replace(['"', ' '],
                  "", $nro) . "[[:>:]]'";
                  } */
                $q[] = "$field like '%" . $this->nro_de_control . "%'";
            }
            $query[] = '(' . implode(' or ', $q) . ')';
        }
        if (!empty($this->conclusion_desde)) {
            $query[] = ' hoja_ruta.conclusion >= :conclusion_desde';
            $params['conclusion_desde'] = $this->conclusion_desde->format('Y-m-d');
        }
        if (!empty($this->conclusion_hasta)) {
            $query[] = ' hoja_ruta.conclusion <= :conclusion_hasta';
            $params['conclusion_hasta'] = $this->conclusion_hasta->format('Y-m-d');
        }
        if (!empty($this->gestion_desde)) {
            $query[] = ' hoja_ruta.gestion >= :gestion_desde';
            $params['gestion_desde'] = $this->gestion_desde;
        }
        if (!empty($this->gestion_hasta)) {
            $query[] = ' hoja_ruta.gestion <= :gestion_hasta';
            $params['gestion_hasta'] = $this->gestion_hasta;
        }
        if (!empty($this->destinatario)) {
            $query[] = ' derivacion.destinatario like :destinatario';
            $params['destinatario'] = '%' . str_replace(' ', '%',
                    $this->destinatario) . '%';
        }
        if (!empty($this->tipo_tarea)) {
            $query[] = ' hoja_ruta.tipo_tarea = :tipo_tarea';
            $params['tipo_tarea'] = $this->tipo_tarea;
        }
        $query = implode("\n and ", $query);
        $query .= " order by derivacion.id";
        $stmt = $connection->prepare($query);
        foreach ($params as $p) {
            if (is_array($p)) {
                $stmt->bindParam(":$p", $p, PDO::PA);
            } else {
                
            }
        }
        $stmt->execute($params);
        $num = 1;
        $res = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $row['num'] = $num;
            $res[] = $row;
            $num++;
        }
        return $res;
    }
}
