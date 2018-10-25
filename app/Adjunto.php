<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\SaveUserTrait;

class Adjunto extends Model
{
    use SoftDeletes, Notifiable, SaveUserTrait;
    protected $table = 'adm_adjuntos';
    protected $fillable = array(
      0 => 'archivo',
      1 => 'tarea_id',
    );
    protected $attributes = array(
      'archivo' => null,
    );
    protected $casts = array(
      'archivo' => 'array',
    );
    protected $events = array(
    );
    public function tarea()
    {
        return $this->belongsTo('App\Tarea');
    }
}
