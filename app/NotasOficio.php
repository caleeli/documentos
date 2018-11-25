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

}
