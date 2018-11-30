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

    use AutoTableTrait;

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
    public function generar()
    {
        $connection = $this->getConnection();

        $query = [];
        $params = [];
        $addDerivacion = false;
        $query[] = ' hoja_ruta.tipo = :tipo';
        $params['tipo'] = $this->tipo;
        if (!empty($this->recepcion_desde)) {
            $query[] = ' hoja_ruta.fecha >= :recepcion_desde';
            $params['recepcion_desde'] = $this->recepcion_desde;
        }
        if (!empty($this->recepcion_hasta)) {
            $query[] = ' hoja_ruta.fecha <= :recepcion_hasta';
            $params['recepcion_hasta'] = $this->recepcion_hasta;
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
            $params['conclusion_desde'] = $this->conclusion_desde;
        }
        if (!empty($this->conclusion_hasta)) {
            $query[] = ' hoja_ruta.conclusion <= :conclusion_hasta';
            $params['conclusion_hasta'] = $this->conclusion_hasta;
        }
        if (!empty($this->gestion_desde)) {
            $query[] = ' hoja_ruta.gestion >= :gestion_desde';
            $params['gestion_desde'] = $this->gestion_desde;
        }
        if (!empty($this->gestion_hasta)) {
            $query[] = ' hoja_ruta.gestion <= :gestion_hasta';
            $params['gestion_hasta'] = $this->gestion_hasta;
        }
        /*if (!empty($this->fecha_derivacion1)) {
            $query[] = ' derivacion.fecha >= :fecha_derivacion1';
            $params['fecha_derivacion1'] = $this->fecha_derivacion1;
            $addDerivacion = true;
        }
        if (!empty($this->fecha_derivacion2)) {
            $query[] = ' derivacion.fecha <= :fecha_derivacion2';
            $params['fecha_derivacion2'] = $this->fecha_derivacion2;
            $addDerivacion = true;
        }*/
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
                . ($addDerivacion ? 'left join derivacion on (derivacion.hoja_ruta_id=hoja_ruta.id) ' : '')
                . ($query ? 'where hoja_ruta.id in '
                . '(select hoja_ruta.id from hoja_ruta left join derivacion on (derivacion.hoja_ruta_id=hoja_ruta.id) where '
                . implode(' and ', $query) . ')' : '');
        } else {
            $esElUltimoDestinatario = 'derivacion.id = (select max(id) from derivacion d2 where d2.hoja_ruta_id=hoja_ruta.id)';
            $query = 'select ' . $select . ' from hoja_ruta '
                . ($addDerivacion ? 'left join derivacion on (derivacion.hoja_ruta_id=hoja_ruta.id and ' . $esElUltimoDestinatario . ') ' : '')
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
        while ($row = $stmt->fetch()) {
            $id = $row['id'];
            if (!isset($res[$id])) {
                $res[$id] = $row;
                $res[$id]['derivaciones'] = [];
            }
            $res[$id]['derivaciones'][] = [
                "fecha" => $row['derivacion_fecha'],
                "destinatario" => $row['derivacion_destinatario'],
                "num" => $num,
            ];
            $num++;
        }
        echo json_encode(array_values($res));
    }
}
