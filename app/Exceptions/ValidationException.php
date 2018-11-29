<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException as Base;
use Exception;

/**
 * ValidationException with translation
 *
 * @author David Callizaya <davidcallizaya@gmail.com>
 */
class ValidationException extends Base
{

    /**
     * Create a new exception instance.
     *
     * @param  \Illuminate\Validation\ValidationException $exception
     *
     * @return void
     */
    public function __construct(Base $exception)
    {
        Exception::__construct(__('exceptions.ValidationException', []));

        $this->response = $exception->response;
        $this->errorBag = $exception->errorBag;
        $this->validator = $exception->validator;
    }
}
