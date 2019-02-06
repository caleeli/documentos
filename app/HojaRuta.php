<?php

namespace App;

use App\Rules\UntilToday;
use App\Traits\SaveUserTrait;
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

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $primaryKey = 'hr_scep_id';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'hr';
    protected $table = 'hoja_ruta';
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
    ];
    protected $appends = [
        'fecha_derivacion',
        'estado',
        'estado',
        'usuario_destinatario',
        'usuario_archivo',
    ];
    protected $casts = [
        'fecha_recepcion' => 'date',
        'fecha_conclusion' => 'date',
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
        $derivacion = $this->getUltimaDerivacion();
        $users = Cache::get('users',
                function() {
                return User::get()->toArray();
            });
        $user = $this->usuario_destinatario;
        $despachado = $user && $user['attributes']['numero_ci'] === User::EXTERNAL_CODE && !in_array($user['attributes']['username'],
                User::RESERVED);
        return $user && $user['attributes']['username'] === User::ARCHIVO ? 'ARCHIVO' : ( $despachado ? 'DESPACHADO' : 'PENDIENTE');
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
        $rules = parent::getRules();
        $rules['fecha_recepcion'][] = new UntilToday();
        $rules['fecha_conclusion'][] = new UntilToday();

        $rules['nro_de_control'][] = Rule::unique('hr.hoja_ruta')
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
}
