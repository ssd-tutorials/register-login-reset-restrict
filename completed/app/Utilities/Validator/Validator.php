<?php

namespace App\Utilities\Validator;

use SSD\StringConverter\Factory;
use Illuminate\Support\Collection;

class Validator
{
    /**
     * @var Collection
     */
    private $rules;

    /**
     * @var Collection
     */
    private $input;

    /**
     * @var array
     */
    public $errors = [];

    /**
     * Validator constructor.
     *
     * @param Collection $rules
     * @param Collection $input
     */
    public function __construct(Collection $rules, Collection $input)
    {
        $this->rules = $rules;
        $this->input = $input;
    }

    /**
     * Validate input.
     *
     * @return bool
     */
    public function isValid()
    {
        if ($this->rules->isEmpty()) {
            return true;
        }

        $this->rules->each([$this, 'validate']);

        return empty($this->errors);
    }

    /**
     * Validate input item.
     *
     * @param string $rules
     * @param string $key
     */
    public function validate($rules, $key)
    {
        if (empty($rules)) {
            return;
        }

        $rules = new Collection(explode('|', $rules));

        $rules->each(function($rule) use($key) {

            $this->evaluateRule($rule, $key);

        });
    }

    /**
     * Evaluate validation rule.
     *
     * @param string $rule
     * @param string $key
     */
    private function evaluateRule($rule, $key)
    {
        $parameters = null;

        $className = explode(":", $rule);

        if (count($className) > 1) {
            $parameters = $className[1];
        }

        $className = $this->validatorClass($className[0]);

        if ( ! (new $className($this->input, $key, $parameters))->validate()) {
            $this->errors[$key][] = $rule;
        }
    }

    /**
     * Get class name with namespace.
     *
     * @param string $rule
     * @return string
     */
    private function validatorClass($rule)
    {
        return __NAMESPACE__ . "\\Rules\\" . Factory::underscoreToClassName($rule);
    }
}