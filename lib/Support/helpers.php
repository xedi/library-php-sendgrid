<?php

if (! function_exists('array_every')) {
    /**
     * Determine if all the items in an array pass the given truth test.
     *
     * @param array         $array    Array to be tested
     * @param callable|null $callable Truth test
     *
     * @return bool
     */
    function array_every(array $array, callable $callable = null): bool
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
     * @param array $array    Array to be tested
     * @param mixed $callable Truth test
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
