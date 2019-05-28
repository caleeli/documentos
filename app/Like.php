<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AutoTableTrait;

class Like extends Model
{
    use SoftDeletes;
    use AutoTableTrait;

    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'hr';
    protected $table = 'likes';

    public function olimpico()
    {
        return $this->belongsTo(Olimpico::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
