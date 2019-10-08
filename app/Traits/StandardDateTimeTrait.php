<?php

namespace App\Traits;

use Carbon\Carbon;
use InvalidArgumentException;

trait StandardDateTimeTrait
{
    /**
     * Return a timestamp as DateTime object.
     *
     * @param mixed $value
     *
     * @return \Carbon\Carbon
     */
    protected function asDateTime($value)
    {
        try {
            //Carbon::W3C is the default format used by moment.js
            //moment().format() --> 2018-10-08T06:54:02-04:00
            $date = Carbon::createFromFormat(Carbon::W3C, $value);
            if ($date->toW3cString() === $value) {
                return $date;
            }
        } catch (InvalidArgumentException $e) {
        }
        return parent::asDateTime($value);
    }
}
