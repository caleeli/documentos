<?php

namespace App;

use App\Traits\SaveUserTrait;
use App\Traits\AutoTableTrait;
use App\Traits\ValidatedModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CgeInterno extends Model
{
    use SoftDeletes;
    use SaveUserTrait;
    use AutoTableTrait;
    use ValidatedModelTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'adm_cge';
    protected $primaryKey = 'cge_id';
    protected $fillable = [
        'cge_descripcion',
    ];
    protected $attributes = [
        'cge_descripcion' => '',
    ];
    protected $casts = [
        'cge_descripcion' => 'string',
    ];
    protected $events = [
    ];

    public function getRules()
    {
        return [
            'cge_descripcion' => ['required'],
        ];
    }
}
