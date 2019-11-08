<?php

namespace App\Traits;

use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * SaveUser
 *
 */
trait SaveUserTrait
{

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSaveUserTrait()
    {
        static::creating(function ($model) {
            $model->user_add = $model->user_add ?? $model->user_add ?: Auth::id();
        });
        static::updating(function ($model) {
            $model->user_mod = Auth::id();
        });
        static::deleting(function ($model) {
            $model->user_del = Auth::id();
        });
    }

    public function userAdd()
    {
        return $this->belongsTo(User::class, 'user_add', 'id');
    }

    public function userMod()
    {
        return $this->belongsTo(User::class, 'user_add', 'id');
    }

    public function userDel()
    {
        return $this->belongsTo(User::class, 'user_add', 'id');
    }
}
