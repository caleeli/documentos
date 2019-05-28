<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AutoTableTrait;

/**
 * Olimpico
 *
 */
class Olimpico extends Model
{
    use SoftDeletes;
    use AutoTableTrait;

    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'hr';
    protected $table = 'olimpicos';

    public function getUrlAttribute()
    {
        return '/olimpicos/' . $this->id;
    }

    public function sugerirAmistad()
    {
        foreach(Olimpico::inRandomOrder()->get() as $amistad) {
            if($amistad->id !== $this->id) {
                return $amistad;
            }
        }
        return $this;
    }

    public function amistades()
    {
        return $this->belongsToMany(Olimpico::class, 'amistades', 'olimpico_id', 'relacion_id')->withPivot('type');
    }
    public function noamistades()
    {
        $ids =  $this->amistades->pluck('id');
        $ids[] = $this->id;
        return self::whereNotIn('id', $ids)->get();
    }
}
