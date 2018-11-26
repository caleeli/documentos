<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Notas oficio
 *
 */
class NotasOficio extends Model
{

    use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'notas_oficio';
    protected $fillable = ["*"];
    protected $appends = [
    ];
    protected $dispatchesEvents = [
        'creating' => [self::class, 'creatingNota'],
    ];

    /**
     * Boot the model
     */
    public static function boot()
    {
        parent::boot();
        //self::observe(self::class);
    }

    public static function creating($callback)
    {
        parent::creating($callback);
    }

    /**
     * 
     * @param self $nota
     */
    public static function creatingNota(self $nota)
    {
        
    }
}
