<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\SaveUserTrait;

class Asignacion extends Model
{
    use SoftDeletes, SaveUserTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'tarea_user';
    protected $guarded = [];
    /*protected $fillable = array(
      0 => 'tarea_tar_id',
      1 => 'user_id',
      2 => 'nro_asignacion',
      3 => 'dias_plazo',
      3 => 'calificacion',
    );*/
    protected $attributes = array(
      'tarea_tar_id' => null,
      'user_id' => null,
      'nro_asignacion' => null,
      'dias_plazo' => null,
    );
    protected $casts = array(
      'tarea_tar_id' => 'int',
      'user_id' => 'integer',
      'nro_asignacion' => 'int',
      'dias_plazo' => 'integer',
    );
    protected $events = array(
    );
    public function avances()
    {
        return $this->hasMany('App\Avance');
    }
}
