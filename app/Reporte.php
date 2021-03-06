<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Description of Reporte
 *
 */
class Reporte extends Model
{
    //use AutoTableTrait;

    public $timestamps = false;
    protected $table = 'reportes';
    protected $attributes = [
        'tipo' => '',
        'recepcion_desde' => null,
        'recepcion_hasta' => null,
        'referencia' => '',
        'procedencia' => '',
        'nro_de_control' => '',
        'conclusion_desde' => null,
        'conclusion_hasta' => null,
        'derivacion_desde' => null,
        'derivacion_hasta' => null,
        'gestion_desde' => '',
        'gestion_hasta' => '',
        'destinatario' => '',
        'tipo_tarea' => '',
        'subtipo_tarea' => '',
        'tipo_reporte' => '',
    ];
    protected $fillable = [
        'tipo',
        'recepcion_desde',
        'recepcion_hasta',
        'referencia',
        'procedencia',
        'nro_de_control',
        'conclusion_desde',
        'conclusion_hasta',
        'derivacion_desde',
        'derivacion_hasta',
        'gestion_desde',
        'gestion_hasta',
        'destinatario',
        'tipo_tarea',
        'subtipo_tarea',
        'tipo_reporte',
    ];
    protected $casts = [
        'recepcion_desde' => 'date',
        'recepcion_hasta' => 'date',
        'conclusion_desde' => 'date',
        'conclusion_hasta' => 'date',
        'derivacion_desde' => 'date',
        'derivacion_hasta' => 'date',
    ];

    public function getProcedencias()
    {
        $entidad = new Entidad();
        $procedencias = [];
        foreach ($entidad->procedencias() as $key => $value) {
            $procedencias[] = [
                'id' => $key,
                'attributes' => [
                    'nombre_completo' => $value->nombre_completo,
                ]
            ];
        }
        return $procedencias;
    }

    public function generar()
    {
        return $this->runQueryFor("SELECT
        derivacion.destinatario,
        concat(hoja_ruta.nro_de_control,' / ',hoja_ruta.gestion) numero,
        hoja_ruta.hr_id,
        hoja_ruta.nro_clasificacion,
        hoja_ruta.tipo_hr,
        hoja_ruta.referencia,
        hoja_ruta.procedencia,
        hoja_ruta.fecha_recepcion,
        hoja_ruta.fecha_conclusion,
        derivacion.fecha as derivacion_fecha,
        derivacion.instruccion,
        derivacion.comentarios,
        hoja_ruta.anexo_hojas,
        tarea.tar_estado,
        tarea.tar_recibidos,
        tarea.tar_atendidos,
        tarea.tar_calificacion
     FROM
       (select hoja_ruta_id, max(id) as id from derivacion group by hoja_ruta_id) ultimos
        inner join derivacion on (ultimos.id=derivacion.id)
        inner join hoja_ruta on (derivacion.hoja_ruta_id=hoja_ruta.hr_id)
        left join tarea on (tarea.hr_id=hoja_ruta.hr_id)
     WHERE 
        1=1
    ");
    }

    private function runQueryFor($queryBase, &$query = '')
    {
        $user = Auth::user();
        $connection = $this->getConnection()->getPdo();

        $params = [];
        $query = [$queryBase];
        if (!empty($this->tipo)) {
            if ($this->tipo[0] != '') {
                $query[] = ' hoja_ruta.tipo_hr IN (' . "'" . implode("', '", $this->tipo) . "'" . ')';
            }
        }
        if (!empty($this->recepcion_desde)) {
            $query[] = ' hoja_ruta.fecha_recepcion >= :recepcion_desde';
            $params['recepcion_desde'] = $this->recepcion_desde->format('Y-m-d');
        }
        if (!empty($this->recepcion_hasta)) {
            $query[] = ' hoja_ruta.fecha_recepcion <= :recepcion_hasta';
            $params['recepcion_hasta'] = $this->recepcion_hasta->format('Y-m-d');
        }
        if (!empty($this->derivacion_desde)) {
            $query[] = ' derivacion.fecha >= :derivacion_desde';
            $params['derivacion_desde'] = $this->derivacion_desde->format('Y-m-d');
        }
        if (!empty($this->derivacion_hasta)) {
            $query[] = ' derivacion.fecha <= :derivacion_hasta';
            $params['derivacion_hasta'] = $this->derivacion_hasta->format('Y-m-d');
        }
        if (!empty($this->referencia)) {
            $query[] = ' hoja_ruta.referencia like :referencia';
            $params['referencia'] = '%' . str_replace(
                ' ',
                '%',
                $this->referencia
            ) . '%';
        }
        if (!empty($this->procedencia)) {
            $query[] = ' hoja_ruta.procedencia like :procedencia';
            $params['procedencia'] = '%' . str_replace(
                ' ',
                '%',
                $this->procedencia
            ) . '%';
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
            $query[] = ' hoja_ruta.fecha_conclusion >= :conclusion_desde';
            $params['conclusion_desde'] = $this->conclusion_desde->format('Y-m-d');
        }
        if (!empty($this->conclusion_hasta)) {
            $query[] = ' hoja_ruta.fecha_conclusion <= :conclusion_hasta';
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
            if (substr($this->destinatario, 0, 1) === '$') {
                $destinatario = substr($this->destinatario, 1);
            } else {
                foreach (explode(',', $this->destinatario) as $userId) {
                    $user = User::find($userId);
                    $destinatario = $user->nombres . ' ' . $user->apellidos;
                }
            }
            $query[] = ' derivacion.destinatario like :destinatario';
            $params['destinatario'] = '%' . str_replace(
                ' ',
                '%',
                $destinatario
            ) . '%';
        }
        if (!empty($this->tipo_tarea)) {
            $query[] = ' hoja_ruta.tipo_tarea = :tipo_tarea';
            $params['tipo_tarea'] = $this->tipo_tarea;
        }
        if (!empty($this->subtipo_tarea)) {
            $query[] = ' hoja_ruta.subtipo_tarea = :subtipo_tarea';
            $params['subtipo_tarea'] = $this->subtipo_tarea;
        }

        if (!empty($this->tipo_reporte)) {
            if ($this->tipo_reporte == 'concluidos') {
                $query[] = ' hoja_ruta.fecha_conclusion IS NOT NULL';
            } elseif ($this->tipo_reporte == 'Pendiente') {
                $query[] = " tarea.tar_estado = 'Pendiente' ";
            } elseif ($this->tipo_reporte == 'Aprobado') {
                $query[] = " tarea.tar_estado = 'Aprobado' ";
            } elseif ($this->tipo_reporte == 'Completado') {
                $query[] = " tarea.tar_estado = 'Completado' ";
            }
        }
        if ($user->role_id == 3) {
            $query[] = ' hoja_ruta.hr_id in (select distinct hoja_ruta_id from derivacion where concat(\',\',destinatarios,\',\') like :usuario_actual) ';
            $params['usuario_actual'] = '%,' . $user->getKey() . ',%';
        }

        $query = implode("\n and ", $query);
        $query .= ' order by derivacion.id';
        /*\Illuminate\Support\Facades\Log::info('valor query: ' . print_r($query, true));
        \Illuminate\Support\Facades\Log::info('valor params: ' . print_r($params, true));*/
        $stmt = $connection->prepare($query);
        //echo "\n",$query,"\n","\n","\n";
        foreach ($params as $k => $p) {
            if (!is_array($p)) {
                $stmt->bindParam($k, $p);
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
        //\Illuminate\Support\Facades\Log::info('valor res: ' . print_r($res, true));
        //DB::enableQueryLog();
        //\Illuminate\Support\Facades\Log::info('valor query: ' . print_r($stmt->queryString, true));
        return $res;
    }

    public function setRecepcionDesdeAttribute($value)
    {
        $datetime = explode('T', $value);
        $this->attributes['recepcion_desde'] = empty($datetime[0]) ? null : $datetime[0];
    }

    public function setRecepcionHastaAttribute($value)
    {
        $datetime = explode('T', $value);
        $this->attributes['recepcion_hasta'] = empty($datetime[0]) ? null : $datetime[0];
    }

    public function setDerivacionDesdeAttribute($value)
    {
        $datetime = explode('T', $value);
        $this->attributes['derivacion_desde'] = empty($datetime[0]) ? null : $datetime[0];
    }

    public function setDerivacionHastaAttribute($value)
    {
        $datetime = explode('T', $value);
        $this->attributes['derivacion_hasta'] = empty($datetime[0]) ? null : $datetime[0];
    }

    public function setConclusionDesdeAttribute($value)
    {
        $datetime = explode('T', $value);
        $this->attributes['conclusion_desde'] = empty($datetime[0]) ? null : $datetime[0];
    }

    public function setConclusionHastaAttribute($value)
    {
        $datetime = explode('T', $value);
        $this->attributes['conclusion_hasta'] = empty($datetime[0]) ? null : $datetime[0];
    }

    public function setTipoAttribute($value)
    {
        $valor = $value;
        if (is_array($value)) {
            if (count($value) > 0) {
                $valor = implode(',', $value);
            } else {
                $valor = null;
            }
        }
        $this->attributes['tipo'] = $valor;
    }

    public function getTipoAttribute($value)
    {
        if (!is_array($this->attributes['tipo'])) {
            $valor = explode(',', $this->attributes['tipo']);
        } else {
            $valor = 'externa';
        }
        return $valor;
    }

    public function generarResumen($rowsType = 'destinatario', $colsType = 'gestion')
    {
        $headers = $this->getDomainValues($colsType);
        $rowTexts = $this->getDomainValues($rowsType);
        $rows = [];
        foreach ($rowTexts as $text) {
            $values = [];
            foreach ($headers as $header) {
                $values[] = $this->getCountsFor($rowsType, $colsType, $text, $header);
            }
            $rows[] = [
                'text' => $text,
                'values' => $values,
            ];
        }
        return compact('headers', 'rows');
    }

    private function getDomainValues($type)
    {
        switch ($type) {
            case 'destinatario':
                return [
                    'Andrés Ortega',
                    'Angela Choque',
                    'Daniel Zapana',
                    'Delfin Ponce',
                    'Eddy Marquez',
                    'Edgar Andrade',
                    'Elena Mallón',
                    'Freddy Cruz',
                    'Maritza Torrez',
                    'Melissa Vargas',
                    'Sonia Velasquez',
                    'Grissel Aviles',
                ];
            case 'gestion':
                $data = [];
                for ($year = 2017, $last = date('Y') * 1; $year <= $last; $year++) {
                    $data[] = $year;
                }
                return $data;
            case 'clasificacion':
                return HojaRutaClasificacion::pluck('sigla')->toArray();
        }
    }

    private function getCountsFor($rowType, $colType, $rowValue, $colValue)
    {
        $this->setValueFor($rowType, $rowValue);
        $this->setValueFor($colType, $colValue);
        //print_r([$rowValue, $colValue]);
        $res = $this->runQueryFor('SELECT
                count(*) as count
            FROM
            (select hoja_ruta_id, max(id) as id from derivacion group by hoja_ruta_id) ultimos
                inner join derivacion on (ultimos.id=derivacion.id)
                inner join hoja_ruta on (derivacion.hoja_ruta_id=hoja_ruta.hr_id)
            WHERE 
                hoja_ruta.fecha_conclusion is not null and hoja_ruta.fecha_conclusion!="0000-00-00"
            ');
        $concluidos = $res && isset($res[0]) && isset($res[0]['count']) ? $res[0]['count'] * 1 : 0;
        $res = $this->runQueryFor('SELECT
                count(*) as count
            FROM
            (select hoja_ruta_id, max(id) as id from derivacion group by hoja_ruta_id) ultimos
                inner join derivacion on (ultimos.id=derivacion.id)
                inner join hoja_ruta on (derivacion.hoja_ruta_id=hoja_ruta.hr_id)
            WHERE 
                not(hoja_ruta.fecha_conclusion is not null and hoja_ruta.fecha_conclusion!="0000-00-00")
            ');
        $pendientes = $res && isset($res[0]) && isset($res[0]['count']) ? $res[0]['count'] * 1 : 0;
        return [$pendientes, $concluidos];
    }

    private function setValueFor($type, $value)
    {
        switch ($type) {
            case 'destinatario':
                // $ significa que al armar el reporte $value es el nombre no el ID del usuario
                $this->destinatario = '$' . $value;
                break;
            case 'gestion':
                $this->gestion_desde = $value;
                $this->gestion_hasta = $value;
                break;
            case 'clasificacion':
                $this->tipo_tarea = $value;
                break;
        }
    }

    /**
     * Un usuario de rol 3 no puede generar reportes de otros destinatarios
     *
     * @param mixed $value
     */
    public function setDestinatarioAttribute($value)
    {
        $user = Auth::user();
        $this->attributes['destinatario'] = $user->role_id == 3 ? $user->getKey() : $value;
    }

    public static function reporte1hr()
    {
        $registradas = self::reporte1registrados();
        $concluidas = self::reporte1concluidas();
        $rows = [];
        foreach ($registradas as $row) {
            $rows[$row['periodo']] = [
                'periodo' => $row['periodo'],
                'registradas' => $row['cantidad'],
                'concluidas' => 0,
            ];
        }
        foreach ($concluidas as $row) {
            if (!$rows[$row['periodo']]) {
                $rows[$row['periodo']]['periodo'] = $row['periodo'];
                $rows[$row['periodo']]['registradas'] = 0;
            }
            $rows[$row['periodo']]['concluidas'] = $row['cantidad'];
        }
        ksort($rows);
        return array_values($rows);
    }

    public static function reporte1registrados()
    {
        return HojaRuta::select(DB::raw(
            "TO_CHAR(fecha_recepcion, 'YYYY-MM') as periodo, count(*) as cantidad"
        ))
            ->groupBy(DB::raw("TO_CHAR(fecha_recepcion, 'YYYY-MM')"))
            ->orderBy('periodo')
            ->get();
    }

    public static function reporte1concluidas()
    {
        return HojaRuta::select(DB::raw(
            "TO_CHAR(fecha_conclusion, 'YYYY-MM') as periodo, count(*) as cantidad"
        ))
            ->whereNotNull('fecha_conclusion')
            ->groupBy(DB::raw("TO_CHAR(fecha_conclusion, 'YYYY-MM')"))
            ->orderBy('periodo')
            ->get();
    }

    public static function reporte1tareas()
    {
        $registradas = self::reporte1registrados_tarea();
        $concluidas = self::reporte1concluidas_tarea();
        $rows = [];
        foreach ($registradas as $row) {
            $rows[$row['periodo']] = [
                'periodo' => $row['periodo'],
                'registradas' => $row['cantidad'],
                'concluidas' => 0,
            ];
        }
        foreach ($concluidas as $row) {
            if (!$rows[$row['periodo']]) {
                $rows[$row['periodo']]['periodo'] = $row['periodo'];
                $rows[$row['periodo']]['registradas'] = 0;
            }
            $rows[$row['periodo']]['concluidas'] = $row['cantidad'];
        }
        ksort($rows);
        return array_values($rows);
    }

    public static function reporte1registrados_tarea()
    {
        return Tarea::select(DB::raw(
            "TO_CHAR(fecha_registro, 'YYYY-MM') as periodo, count(*) as cantidad"
        ))
            ->groupBy(DB::raw("TO_CHAR(fecha_registro, 'YYYY-MM')"))
            ->orderBy('periodo')
            ->get();
    }

    public static function reporte1concluidas_tarea()
    {
        return Tarea::select(DB::raw(
            "TO_CHAR(tar_fecha_fin, 'YYYY-MM') as periodo, count(*) as cantidad"
        ))
            ->whereNotNull('tar_fecha_fin')
            ->groupBy(DB::raw("TO_CHAR(tar_fecha_fin, 'YYYY-MM')"))
            ->orderBy('periodo')
            ->get();
    }

    public static function reporte2bitacora_mensual()
    {
        return Tarea::select(DB::raw(
            "TO_CHAR(fecha_registro, 'YYYY-MM') as periodo,
                count(*) as asignados,
                sum(case tar_estado when 'Completado' then 0 else 1 end) as pendientes,
                sum(case tar_estado when 'Completado' then 1 else 0 end) as completados"
        ))
            ->whereNotNull('fecha_registro')
            ->groupBy(DB::raw("TO_CHAR(fecha_registro, 'YYYY-MM')"))
            ->orderBy('periodo')
            ->get();
    }

    public static function reporte3mes()
    {
        return Tarea::select(DB::raw(
            "TO_CHAR(fecha_registro, 'YYYY-MM') as periodo,
                sum(case tar_estado when 'Aprobado' then 1 else 0 end) as aprobados,
                sum(case tar_estado when 'Pendiente' then 1 else 0 end) as pendientes,
                sum(case tar_estado when 'Completado' then 1 else 0 end) as completados"
        ))
            ->whereNotNull('fecha_registro')
            ->groupBy(DB::raw("TO_CHAR(fecha_registro, 'YYYY-MM')"))
            ->orderBy('periodo')
            ->get();
    }

    public static function reporte3mes_usuario($periodo)
    {
        return DB::select(
            "
            select 
                1 as subreport,
                (select concat(nombres, ' ', apellidos) from adm_users where id = tu.user_id) as usuario,
                sum(case ta.tar_estado when 'Aprobado' then 1 else 0 end) as aprobados,
                sum(case ta.tar_estado when 'Pendiente' then 1 else 0 end) as pendientes,
                sum(case ta.tar_estado when 'Completado' then 1 else 0 end) as completados
            from
                tarea_user as tu left join tarea as ta on (tu.tarea_tar_id = ta.tar_id)
            where
                tu.fecha_baja is null
                and ta.fecha_baja is null
                and ta.fecha_registro is not null
                and TO_CHAR(ta.fecha_registro, 'YYYY-MM') = :periodo
            group by
                tu.user_id
            ",
            [
                'periodo' => $periodo,
            ]
        );
    }

    public static function reporte3usuario()
    {
        return DB::select(
            "
            select 
                (select concat(nombres, ' ', apellidos) from adm_users where id = tu.user_id) as usuario,
                tu.user_id,
                sum(case ta.tar_estado when 'Aprobado' then 1 else 0 end) as aprobados,
                sum(case ta.tar_estado when 'Pendiente' then 1 else 0 end) as pendientes,
                sum(case ta.tar_estado when 'Completado' then 1 else 0 end) as completados
            from
                tarea_user as tu left join tarea as ta on (tu.tarea_tar_id = ta.tar_id)
            where
                tu.fecha_baja is null
                and ta.fecha_baja is null
                and ta.fecha_registro is not null
            group by
                tu.user_id
            order by
                usuario
            ",
            [
            ]
        );
    }

    public static function reporte3usuario_mes($usuario)
    {
        return DB::select(
            "
            select
                1 as subreport,
                TO_CHAR(ta.fecha_registro, 'YYYY-MM') as periodo,
                sum(case ta.tar_estado when 'Aprobado' then 1 else 0 end) as aprobados,
                sum(case ta.tar_estado when 'Pendiente' then 1 else 0 end) as pendientes,
                sum(case ta.tar_estado when 'Completado' then 1 else 0 end) as completados
            from
                tarea_user as tu left join tarea as ta on (tu.tarea_tar_id = ta.tar_id)
            where
                tu.fecha_baja is null
                and ta.fecha_baja is null
                and ta.fecha_registro is not null
                and tu.user_id = :usuario
            group by
                TO_CHAR(ta.fecha_registro, 'YYYY-MM')
            order by
                periodo
            ",
            [
                'usuario' => $usuario,
            ]
        );
    }

    public static function reporte4($mensual = true)
    {
        $format = $mensual ? 'YYYY-MM' : 'YYYY-WW';
        return Tarea::select(DB::raw(
            "TO_CHAR(fecha_registro, '{$format}') as periodo,
                count(*) as asignados,
                sum(case tar_estado when 'Aprobado' then 1 else 0 end) as aprobados,
                sum(case tar_estado when 'Pendiente' then 1 else 0 end) as pendientes,
                sum(case tar_estado when 'Completado' then 1 else 0 end) as completados,
                avg(tar_calificacion) as calificacion
            "
        ))
            ->whereNotNull('fecha_registro')
            ->groupBy(DB::raw("TO_CHAR(fecha_registro, '{$format}')"))
            ->orderBy('periodo')
            ->get();
    }
}
