<?php

namespace App;

use App\Traits\SaveUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AutoTableTrait;
use Illuminate\Support\Facades\Auth;

/**
 * Menu
 *
 */
class Menu extends Model
{
    //use SaveUserTrait;
    use SoftDeletes;
    use AutoTableTrait;

    public $incrementing = true;
    public $timestamps = true;
    protected $table = 'menu';
    protected $casts = [
        'roles' => 'array',
    ];

    public function scopeWhereIsChildren($query, $parentId)
    {
        $user = Auth::user();
        $query->where('parent', $parentId);
        //$query = $user->role_id == 3 ? $query->where('name', '!=', 'Registrar') : $query;
        return $query;
    }

    public function scopeWhereIsRoot($query)
    {
        $user = Auth::user();
        $query->where('parent', 0);
        //$query = $user->role_id == '2' ? $query->where('id', '!=', '900') : $query;
        return $query;
    }

    public function scopeWhereAuth($query, $user = null)
    {
        $user = $user ?: Auth::user();
        $query->whereJsonContains('roles->enabled', $user->role_id);
        return $query;
    }
}
