<?php

namespace App;

use App\Traits\AutoTableTrait;
use App\Traits\SaveUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Module extends Model
{
    //use SaveUserTrait;
    use SoftDeletes;
    use AutoTableTrait;

    public $incrementing = true;
    public $timestamps = true;
    protected $table = 'modules';
    protected $casts = [
        'roles' => 'array',
    ];

    public function scopeWhereAuth($query, $user = null)
    {
        $user = $user ?: Auth::user();
        $query->whereJsonContains('roles->enabled', $user->role_id);
        return $query;
    }
}
