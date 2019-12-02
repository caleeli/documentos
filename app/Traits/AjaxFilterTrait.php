<?php

namespace App\Traits;

/**
 * AjaxFilterTrait
 *
 */
trait AjaxFilterTrait
{
    public function scopeWhereAjaxFilter($query, $filter, ...$fields)
    {
        if (empty($filter) || empty($fields)) {
            return $query;
        }
        return $query->where(function ($select) use ($filter, $fields) {
            $relFilter = [];
            foreach ($fields as $field) {
                $relation = false;
                if (substr($field, 0, 1) === '@') {
                    list($relation, $subField) = explode('.', substr($field, 1));
                    $params = [$subField, 'ilike', "%$filter%"];
                    $relFilter[$relation][] = ['orWhereHas', $params];
                } else {
                    $params = [$field, 'ilike', "%$filter%"];
                    $select = $select->orWhere(...$params);
                }
            }
            foreach ($relFilter as $relationName => $relations) {
                foreach ($relations as $relation) {
                    list($method, $params) = $relation;
                    $select = $select->$method($relationName, function ($select) use ($params) {
                        call_user_func_array([$select, 'where'], $params);
                    });
                }
            }
        });
    }
}
