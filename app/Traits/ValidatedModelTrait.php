<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

/**
 * Validates a model
 *
 */
trait ValidatedModelTrait
{

    private $validationErrors;

    /**
     * Get rules of the model.
     *
     */
    abstract protected function getRules();

    public static function bootValidatedModelTrait()
    {
        static::observe(new ValidatingObserver);
    }

    public function validate()
    {
        $data = [];
        foreach ($this->attributes as $key => $value) {
            $data[$key] = $this->getAttributeValue($key);
        }
        // make a new validator object
        /* @var $v \Illuminate\Validation\Validator */
        $v = Validator::make($data, $this->getRules());

        $v->validate();
    }

    /**
     * Returns whether the model is valid or not.
     *
     * @return bool
     */
    private function isValid()
    {
        $data = $this->toArray();

        // make a new validator object
        /* @var $v \Illuminate\Validation\Validator */
        $v = Validator::make($data, $this->getRules());

        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->validationErrors = $v->errors();
            return false;
        }

        // validation pass
        return true;
    }

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
            $date = Carbon::createFromFormat(Carbon::W3C, $value);
            if ($date->toW3cString() === $value) {
                return $date;
            }
        } catch (InvalidArgumentException $e) {
            
        }
        return parent::asDateTime($value);
    }
}
