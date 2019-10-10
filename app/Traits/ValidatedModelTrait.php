<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

/**
 * Validates a model
 *
 */
trait ValidatedModelTrait
{
    use StandardDateTimeTrait;

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
            $data[$key] = $this->$key; //getAttributeValue($key);
        }
        // make a new validator object
        /* @var $v \Illuminate\Validation\Validator */
        $rules = [];
        foreach ($this->getRules() as $key => $val) {
            if (is_array($val) && !in_array('required', $val)) {
                $val[] = 'nullable';
            }
            $rules[$key] = $val;
        }
        $v = Validator::make($data, $rules);

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
