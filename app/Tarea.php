<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SaveUserTrait;
use App\Traits\ValidatedModelTrait;
use Illuminate\Support\Facades\Auth;

class Tarea extends Model
{
    use SoftDeletes, SaveUserTrait;
    use ValidatedModelTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'tarea';
    protected $primaryKey = 'tar_id';
    protected $guarded = [];
    protected $casts = [
        'tar_fecha_derivacion' => 'datetime',
        'tar_fecha_fin' => 'datetime',
    ];
    protected $events = [
        //'saved' => 'App\\Events\\UserAdministration\\TareaSaved',
    ];
    protected $appends = [
        //0 => 'dias_pasados',
        //1 => 'ultima_asignacion',
    ];

    public function getRules()
    {
        return [
            'tar_avance' => ['int', 'max:100', 'min:0'],
            'tar_calificacion' => ['int', 'max:100', 'min:0'],
        ];
    }

    public function usuarios()
    {
        return $this->belongsToMany('App\User');
    }

    public function tar_creador()
    {
        return $this->belongsTo('App\User');
    }

    public function revisor1()
    {
        return $this->belongsTo('App\User');
    }

    public function aprobacion1()
    {
        return $this->belongsTo('App\User');
    }

    public function revisor2()
    {
        return $this->belongsTo('App\User');
    }

    public function aprobacion2()
    {
        return $this->belongsTo('App\User');
    }

    public function adjuntos()
    {
        return $this->hasMany('App\Adjunto');
    }

    public function avances()
    {
        return $this->hasMany('App\Avance');
    }

    public function asignaciones()
    {
        return $this->hasMany('App\Asignacion');
    }

    public function enlaces()
    {
        return $this->belongsToMany('App\Tarea', 'enlace_tarea', 'tarea_id', 'enlace_tarea_id');
    }

    public function scopeWhereUserAssigned($query, $userId = null, $ownerId = null)
    {
        if (Auth::user()->role_id == 1) {
            return $query;
        }
        $userId = $userId ?: Auth::id();
        $ownerId = $ownerId ?: Auth::id();
        return $query->whereIn('tar_id', function ($query) use ($userId) {
            $query->select('tarea_tar_id')
                ->from('tarea_user')
                ->where('user_id', $userId);
        })->orWhere('tar_creador_id', $ownerId);
    }

    public function getDiasPasadosAttribute()
    {
        return $this->created_at->diff(\Carbon\Carbon::now())->days;
    }

    public function getDiasOtorgadosAttribute()
    {
        $asignacion = $this->asignaciones()->orderBy('created_at', 'desc')->first();
        return $asignacion ? $asignacion->dias_plazo * 1 : 0;
    }

    public function getAvanceAttribute()
    {
        $avancesPorPersona = [];
        $lastAsignation = $this->asignaciones()->max('nro_asignacion');
        $avances = $this->avances()->with('asignacion')->orderBy('id', 'asc')->get();
        foreach ($avances as $avance) {
            if ($avance->asignacion && $avance->asignacion->nro_asignacion == $lastAsignation) {
                $avancesPorPersona[$avance->usuario_abm_id] = $avance->avance;
            }
        }
        $total = array_sum($avancesPorPersona);
        $count = $this->asignaciones()->where('nro_asignacion', $lastAsignation)->count();
        return $count > 0 ? $total / $count : 0;
    }

    public function getUltimaAsignacionAttribute()
    {
        $asignaciones = $this->asignaciones()->orderBy('id', 'desc')->get();
        $ultimos = [];
        $first = false;
        foreach ($asignaciones as $asignacion) {
            $first = $first ?: $asignacion->nro_asignacion;
            if ($first == $asignacion->nro_asignacion) {
                $ultimos[$asignacion->user_id] = $asignacion->id;
            }
        }
        return $ultimos;
    }

    public function derivacion()
    {
        return $this->belongsTo(Derivacion::class, 'derhr_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'tar_id');
    }
}
