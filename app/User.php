<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable,
        AutoTableTrait;

    protected $table = 'adm_users';

    const RESERVED = ['correspondencia', 'archivo'];
    const EXTERNAL_CODE = '123456';
    const ARCHIVO = 'archivo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'destinatario_hoja_ruta',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];
    protected $casts = [
        'fotografia' => 'array',
        'destinatario_hoja_ruta' => 'boolean',
    ];
    protected $appends = [
        'nombre_completo'
    ];

    //protected $dateFormat = 'Y-m-d\TH:i:s.u+';

    /**
     * Generates a API token for the user.
     *
     * @return string
     */
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function scopeWhereNoReservado($query)
    {
        return $query->where('reservado', 0);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = md5($value);
    }

    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'tarea_user', 'user_id', 'tarea_tar_id');
    }
}
