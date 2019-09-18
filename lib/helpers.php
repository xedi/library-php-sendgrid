<?php

use Closure;

if (! function_exists('class_uses_recursive')) {
    /**
     * Returns all traits used by a class, its parent classes and trait of their traits.
     *
     * @param  object|string  $class
     *
     * @return array
     */
    function class_uses_recursive($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $results = [];

        foreach (array_reverse(class_parents($class)) + [$class => $class] as $class) {
            $results += trait_uses_recursive($class);
        }

        return array_unique($results);
    }
}

if (! function_exists('trait_uses_recursive')) {
    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param  string  $trait
     *
     * @return array
     */
    function trait_uses_recursive($trait)
    {
        $traits = class_uses($trait);

        foreach ($traits as $trait) {
            $traits += $trait_uses_recursive($trait);
        }

        return $traits;
    }
}

if (! function_exists('array_every')) {
    /**
     * Determine if all the items in an array pass the given test.
     *
     * @param  array        $array    Array to be tested
     * @param  Closure|null $callable Test
     *a
     * @return bool
     */
    function array_every(array $array, Closure $callable = null): bool
    {
        $original_count = count($array);
        $filtered_count = count(
            array_filter($array, $callable)
        );

        return $original_count === $filtered_count;
    }
}

if (! function_exists('reject')) {
    /**
     * Create an array of all elements that do not pass a given truth test.
     *
     * @param  array $array
     * @param  mixed $callable
     *
     * @return array
     */
    function reject(array $array, $callable = true): array
    {
        $use_as_callable = ! is_string($callable) && is_callable($callable);

        return array_filter(
            $array,
            function ($value, $key) use ($callable, $use_as_callable) {
                return $use_as_callable ?
                    ! $callable($value, $key) :
                    $value !== $callable;
            }
        );
    }
}

if (! function_exists('optional')) {
    /**
     * Provide access to optional objects.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     *
     * @return mixed
     */
    function optional($value = null, callable $callable = null)
    {
        if (is_null($callable)) {
            return new Optional($value);
        } elseif (! is_null($value)) {
            return $callable($value);
        }
    }
}
