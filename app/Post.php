<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AutoTableTrait;

class Post extends Model
{
    use SoftDeletes;
    use AutoTableTrait;

    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'hr';
    protected $table = 'posts';

    public function olimpico()
    {
        return $this->belongsTo(Olimpico::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikenamesAttribute()
    {
        $names = [];
        foreach($this->likes as $like) {
            $names[$like->olimpico->name] = $like->olimpico->name;
        }
        return implode(', ', $names);
    }

    public function getEmojisAttribute()
    {
        $emojis = [];
        foreach($this->likes as $like) {
            $emojis[$like->type] = $like->type;
        }
        return implode('', $emojis);
    }
}
