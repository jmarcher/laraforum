<?php
/**
 * Wrapper around factory()->create()
 */
if (!function_exists('create')) {
    function create($class, $attributes = [])
    {
        return factory($class)->create($attributes);
    }
}

/**
 * Wrapper around factory()->make()
 */
if (!function_exists('make')) {
    function make($class, $attributes = [])
    {
        return factory($class)->make($attributes);
    }
}
