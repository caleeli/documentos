<?php

namespace App;

use App\Rules\UntilToday;
use App\Traits\SaveUserTrait;
use App\Traits\ValidatedModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

/**
 * Hoja de Ruta
 *
 * delete from derivacion where hoja_ruta_id=0;
 * insert into hoja_ruta (id, fecha, referencia,procedencia,nro_de_control,anexo_hojas,destinatario,numero) select distinct hoja_ruta_id, now(), 'S/R', '(vacio)', 'S/N', '', '','-1' from derivacion where hoja_ruta_id not in (select id from hoja_ruta)
 */
class HojaRuta extends Model
{

    use SaveUserTrait;
    use SoftDeletes;
    use ValidatedModelTrait;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $primaryKey = 'hr_id';
    public $incrementing = true;
    public $timestamps = true;
    protected $table = 'hoja_ruta';
    protected $attributes = [
        'tipo_hr' => 'celeste',
        'anexo_hojas' => '',
    ];
    protected $fillable = [
        "fecha_recepcion",
        "referencia",
        "procedencia",
        "nro_de_control",
        "anexo_hojas",
        "destinatario",
        "fecha_conclusion",
        "tipo_hr",
        "gestion",
        "numero",
        "tipo_tarea",
        "subtipo_tarea",
        "tipo_procedencia"
    ];
    protected $appends = [
        'fecha_derivacion',
        'estado',
        'usuario_destinatario',
        'usuario_archivo',
        'tipo_hr_desc',
    ];
    protected $casts = [
        'fecha_recepcion' => 'datetime',
        'fecha_conclusion' => 'datetime',
    ];
    protected $dates = ['deleted_at'];

    /**
     * Fecha de derivacion
     * 
     * @return string
     */
    public function getFechaDerivacionAttribute()
    {
        $derivacion = $this->getUltimaDerivacion();
        return $derivacion ? $derivacion->fecha->format($this->getDateFormat()) : null;
    }

    public function derivacion()
    {
        return $this->hasMany(Derivacion::class, 'hoja_ruta_id');
    }

    public function getUltimaDerivacion()
    {
        return $this->derivacion()->orderBy('id', 'desc')->first();
    }

    /**
     * Estado de la ultima derivacion
     * 
     * @return string
     */
    public function getEstadoAttribute()
    {
        return $this->fecha_conclusion ? 'CONCLUIDO' : 'PENDIENTE';
    }

    /**
     * Obtiene el usuario correspondiente al usuario.
     *
     */
    public function getUsuarioDestinatarioAttribute()
    {
        $derivacion = $this->getUltimaDerivacion();
        $user = $derivacion && $derivacion->destinatarios ? User::find(explode(',',
                    $derivacion->destinatarios)[0]) : null;
        return $user ? ['id' => $user['id'], 'attributes' => $user] : $user;
    }

    /**
     * Obtiene el usuario ante penultimo.
     *
     */
    public function getUsuarioArchivoAttribute()
    {
        $derivacion = $this->derivacion()->orderBy('id', 'desc')->skip(2)->first();
        $user = $derivacion && $derivacion->destinatarios ? User::find(explode(',',
                    $derivacion->destinatarios)[0]) : null;
        return $user ? ['id' => $user['id'], 'attributes' => $user] : $user;
    }

    /**
     * Reglas de validacion para la derivacion.
     *
     * @return array
     */
    protected function getRules()
    {
        $rules = [
            "fecha_recepcion" => ['required'],
            "referencia" => ['required'],
            "procedencia" => ['required'],
            "nro_de_control" => ['required'],
            //"anexo_hojas" => ['required'],
            "destinatario" => ['required'],
            "tipo_hr" => ['required'],
            "numero" => ['required'],
            "tipo_tarea" => ['required'],
            "subtipo_tarea" => ['required'],
            "tipo_procedencia" => ['required'],
        ];
        $rules['fecha_recepcion'][] = new UntilToday();
        $rules['fecha_conclusion'][] = new UntilToday();

        $rules['nro_de_control'][] = Rule::unique('hoja_ruta')
            ->where(function ($query) {
            if ($this->exists) {
                $query = $query->where($this->getKeyName(), '!=',
                    $this->getKey());
            }
            return $query->where('gestion', $this->gestion)
                ->where('nro_de_control', $this->nro_de_control);
        });
        return $rules;
    }

    public function getNumeroSecuencia($tipo)
    {
        $numero = HojaRuta::where('gestion', date('Y'))->where('tipo_hr', $tipo)->max('numero') + 1;
        return $numero;
    }

    public function getTipoHrDescAttribute()
    {
        $labels = [
            'externa' => 'Celeste',
            'interna' => 'Rosada',
            'solicitud' => 'Amarilla',
        ];
        return $labels[$this->tipo_hr];
    }


}
