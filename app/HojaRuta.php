<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Hoja de Ruta
 *
 * delete from derivacion where hoja_ruta_id=0;
 * insert into hoja_ruta (id, fecha, referencia,procedencia,nro_de_control,anexo_hojas,destinatario,numero) select distinct hoja_ruta_id, now(), 'S/R', '(vacio)', 'S/N', '', '','-1' from derivacion where hoja_ruta_id not in (select id from hoja_ruta)
 */
class HojaRuta extends Model
{

    use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'hoja_ruta';
    protected $appends = [
        'fecha_derivacion',
        'estado',
        'estado',
        'usuario_destinatario',
    ];

    /**
     * Fecha de derivacion
     * 
     * @return string
     */
    public function getFechaDerivacionAttribute()
    {
        $derivacion = $this->getUltimaDerivacion();
        return $derivacion ? $derivacion->fecha : null;
    }

    public function getUltimaDerivacion()
    {
        return $this->derivacion()->orderBy('id', 'desc')->first();
    }

    /**
     * Fecha de derivacion
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
        $despachado = $user && $user['attributes']['numero_ci'] === User::EXTERNAL_CODE
            && !in_array($user['attributes']['username'], User::RESERVED);
        return $user && $user['attributes']['username'] === User::ARCHIVO ? 'ARCHIVO' : ( $despachado ? 'DESPACHADO' : 'PENDIENTE');
    }

    /**
     * Obtiene el usuario correspondiente al usuario.
     *
     */
    public function getUsuarioDestinatarioAttribute()
    {
        $derivacion = $this->getUltimaDerivacion();
        $user = $derivacion && $derivacion->destinatarios ? User::find(explode(',', $derivacion->destinatarios)[0]) : null;
        return $user ? ['id' =>$user['id'], 'attributes'=> $user] : $user;
    }

    public function g1etUsuarioDestinatarioAttribute()
    {
        $users = Cache::get('users',
                function() {
                return User::get()->toArray();
            });
        $user = null;
        foreach ($users as $scepUser) {
            if (trim($this->destinatario) === trim($scepUser['nombres'] . ' ' . $scepUser['apellidos'])) {
                $user = $scepUser;
                break;
            }
        }
        return $user ? ['id' =>$user['id'], 'attributes'=> $user] : $user;
    }
}
