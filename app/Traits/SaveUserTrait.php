<?php

namespace App\Traits;

use Exception;
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
            $model->user_add = Auth::id();
        });
        static::updating(function ($model) {
            $model->user_mod = Auth::id();
        });
        static::deleting(function ($model) {
            $model->user_del = Auth::id();
        });
    }
}
