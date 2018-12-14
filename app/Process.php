<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Traits\AutoTableTrait;

class Process extends Model
{

    //use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'processes';
    protected $attributes = [
        "data" => '{}',
        "tokens" => '{}',
        "status" => 'ACTIVE',
    ];
    protected $fillable = [
        "data",
        "tokens",
        "status",
    ];
    protected $casts = [
        "data" => "array",
        "tokens" => "array",
    ];

}
