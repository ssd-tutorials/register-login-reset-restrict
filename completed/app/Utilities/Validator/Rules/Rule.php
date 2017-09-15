<?php

namespace App\Utilities\Validator\Rules;

use Illuminate\Support\Collection;

abstract class Rule
{
    /**
     * @var Collection
     */
    protected $input;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var null|Collection
     */
    protected $parameters;

    /**
     * Rule constructor.
     *
     * @param Collection $input
     * @param string $key
     * @param Collection|null $parameters
     */
    public function __construct(Collection $input, $key, $parameters)
    {
        $this->input = $input;
        $this->key = $key;

        $this->processParameters($parameters);
    }

    /**
     * Process parameters.
     *
     * @param null|string $parameters
     */
    private function processParameters($parameters = null)
    {
        if (is_null($parameters)) {
            return;
        }

        $parameters = explode(',', $parameters);
        $collection = new Collection($parameters);

        $this->parameters = $collection->map('trim');
    }

    /**
     * Validate input.
     *
     * @return bool
     */
    abstract public function validate();
}