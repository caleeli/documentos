<?php

namespace App;

use App\Traits\SaveUserTrait;
use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Entidad extends Model
{

    use SoftDeletes,
        Notifiable,
        SaveUserTrait;
    use AutoTableTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'adm_entidad';
    protected $fillable = [
        'ent_id',
        'ent_clasificador',
        'end_descripcion',
        'ent_sigla'
    ];
    protected $attributes = array(
        'ent_id' => '',
        'ent_clasificador' => '',
        'end_descripcion' => '',
        'ent_sigla' => '',
    );
    protected $casts = array(
        'ent_id' => 'string',
        'ent_clasificador' => 'string',
        'end_descripcion' => 'string',
        'ent_sigla' => 'string',
    );
    protected $events = array(
    );

    public function procedencias()
    {
        $sql = "select ent_descripcion as nombre from adm_entidad
                union
                select concat(per_nombres, ' ', per_apellidos, ' - ', per_ci_nit) as nombre from adm_persona";
        $res = \DB::select($sql);
        return ["data" => $res];
    }
}
