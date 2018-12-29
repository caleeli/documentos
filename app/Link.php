<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{

    use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'links';
    protected $fillable = [
        "text",
        "icon",
        "description",
        "href",
        "links",
    ];
    protected $casts = [
        'links' => 'array',
    ];

}
