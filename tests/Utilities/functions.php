<?php
/**
 * Wrapper around factory()->create()
 */
if (!function_exists('create')) {
    function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }
}

/**
 * Wrapper around factory()->make()
 */
if (!function_exists('make')) {
    function make($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->make($attributes);
    }
}
