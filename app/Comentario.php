<?php

namespace App;

use App\Traits\SaveUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of Comentario
 *
 */
class Comentario extends Model
{
    use SoftDeletes, SaveUserTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'comentario';
    protected $primaryKey = 'com_id';
    protected $guarded = [];
    protected $casts = [
        //'com_fecha' => 'date',
        'fecha_registro' => 'date',
        'fecha_modificacion' => 'date',
        'fecha_baja' => 'date',
    ];
}
