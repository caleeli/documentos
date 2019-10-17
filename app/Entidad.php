<?php

namespace App;

use App\Traits\SaveUserTrait;
use App\Traits\AutoTableTrait;
use App\Traits\ValidatedModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Entidad extends Model
{

    use SoftDeletes,
        Notifiable;
    use SaveUserTrait;
    use AutoTableTrait;
    use ValidatedModelTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'adm_entidad';
    protected $primaryKey = 'ent_id';
    protected $fillable = [
        'ent_clasificador',
        'ent_descripcion',
        'ent_sigla'
    ];
    protected $attributes = array(
        'ent_clasificador' => '',
        'ent_descripcion' => '',
        'ent_sigla' => '',
    );
    protected $casts = array(
        'ent_id' => 'string',
        'ent_clasificador' => 'string',
        'ent_descripcion' => 'string',
        'ent_sigla' => 'string',
    );
    protected $events = array(
    );

    public function procedencias()
    {
        $sql = "select ent_descripcion as nombre_completo from adm_entidad
                union
                select concat(per_nombres, ' ', per_apellidos, ' - ', per_ci_nit) as nombre_completo from adm_persona";
        $res = \DB::select($sql);
        return $res;
    }

    public function getRules()
    {
        return [
            'ent_clasificador' => ['unique:adm_entidad'],
            'ent_sigla' => ['unique:adm_entidad'],
            'ent_descripcion' => ['required'],
        ];
    }
}
