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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        //'alguna_fecha' => 'datetime'
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
}
