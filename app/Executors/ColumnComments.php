<?php
namespace App\Executors;

/**
 * Evalua expresiones escritas en los comentarios de las columnas
 *
 * @author David Callizaya <davidcallizaya@gmail.com>
 */
class ColumnComments extends Executor
{

    public function password($column, $rememberToken)
    {
        return ['password', $column, $rememberToken];
    }
}
