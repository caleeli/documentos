<?php

namespace App;

use App\Traits\SaveUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AutoTableTrait;

/**
 * Menu
 * 
 */
class Menu extends Model
{

    use SaveUserTrait;
    use SoftDeletes;
    use AutoTableTrait;

    public $incrementing = true;
    public $timestamps = true;
    protected $table = 'menu';

}
