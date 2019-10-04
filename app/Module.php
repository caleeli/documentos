<?php

namespace App;

use App\Traits\AutoTableTrait;
use App\Traits\SaveUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SaveUserTrait;
    use SoftDeletes;
    use AutoTableTrait;

    public $incrementing = true;
    public $timestamps = true;
    protected $table = 'modules';
}
