<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Binder
{
    /**
     * Bind properties.
     *
     * @param Collection $collection
     * @return void
     */
    protected function bind(Collection $collection)
    {
        if ($collection->isEmpty()) {
            return;
        }

        $collection->filter([$this, 'filterBindings'])
                   ->each([$this, 'bindProperties']);
    }

    /**
     * Get only items that represent existing properties.
     *
     * @param mixed $value
     * @param string $key
     * @return bool
     */
    public function filterBindings($value, $key)
    {
        return property_exists($this, $key);
    }

    /**
     * Bind value to the property.
     *
     * @param mixed $value
     * @param string $key
     */
    public function bindProperties($value, $key)
    {
        $this->{$key} = $value;
    }
}