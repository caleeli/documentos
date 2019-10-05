<?php

namespace App;

use App\Traits\SaveUserTrait;
use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Persona extends Model
{

    use SoftDeletes,
        Notifiable,
        SaveUserTrait;
    use AutoTableTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'adm_persona';

    protected $primaryKey = 'per_id';

    protected $fillable = [
        'per_id',
        'per_nombres',
        'per_apellidos',
        'per_ci_nit',
        'per_tipo_persona',
    ];
    protected $attributes = array(
        'per_id' => '',
        'per_nombres' => '',
        'per_apellidos' => '',
        'per_ci_nit' => '',
        'per_tipo_persona' => '',
    );
    protected $casts = array(
      'per_id' => '',
      'per_nombres' => '',
      'per_apellidos' => '',
      'per_ci_nit' => '',
      'per_tipo_persona' => '',
    );
    protected $appends = array(
      'nombre_completo',
    );
    protected $events = array(
    );

    public function getNombreCompletoAttribute($value){
      $nomCompleto = "{$this->per_nombres} {$this->per_apellidos} - {$this->per_ci_nit}";
      return $nomCompleto;
    }

    public function getSecuencia()
    {
        $numero = Persona::max('per_id') + 1;
        return $numero;
    }

}
