<?php
namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Validates a model
 *
 */
trait ValidatedModelTrait
{

    private $validationErrors;

    protected function getRules()
    {
        return [];
    }

    public static function bootValidatedModelTrait()
    {
        static::observe(new ValidatingObserver);
    }

    public function validate()
    {
        $data = [];
        foreach($this->attributes as $key => $value) {
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
}
