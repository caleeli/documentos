<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * CorrelativoTrait
 *
 */
trait CorrelativoTrait
{
    public static function bootCorrelativoTrait()
    {
        static::created([static::class, 'actualizarCorrelativo']);
    }

    public static function actualizarCorrelativo(Model $model)
    {
        $changed = false;
        foreach ($model->getCorrelativos() as $column => $where) {
            $changed = true;
            $model->{$column} = $model->getCorrelativo($column);
        }
        $changed ? $model->save() : null;
    }

    public function getCorrelativo($name)
    {
        $where = $this->correlativos[$name];
        $query = static::where($where);
        $this->getKey() ? $query = $query->where($this->getKeyName(), '<=', $this->getKey()) : null;
        return $query->count();
    }

    public function getCorrelativos()
    {
        return $this->correlativos;
    }
}
