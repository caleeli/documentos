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
    //protected $fillable = ['com_texto', 'tar_id', 'user_add'];
    protected $guarded = [];
    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'fecha_baja' => 'datetime',
    ];
    protected $dates = [
        'fecha_registro',
        'fecha_modificacion',
        'fecha_baja',
    ];
    protected $attributes = [
        'com_texto' => '',
    ];
    protected $appends = [
        'nombre_usuario',
        'usuario',
    ];

    public function getNombreUsuarioAttribute()
    {
        $userAdd = $this->usuario;
        return $userAdd ? $userAdd->nombre_completo : '';
    }

    public function getUsuarioAttribute()
    {
        return $this->userAdd()->first();
    }
}
