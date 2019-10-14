<?php
namespace App\Executors;

/**
 * Evalua expresiones escritas en los comentarios de las columnas
 *
 */
class ColumnComments extends Executor
{

    public function password($column, $rememberToken)
    {
        return ['password', $column, $rememberToken];
    }
}
