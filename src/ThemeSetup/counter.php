<?php

if(!function_exists('index_counter')):
    function index_counter(string $counterName, int $start = 0, int $step = 1): int
    {
        $cacheValue = wp_cache_get($counterName, 'index_counter');

        if($cacheValue === false) {
            $cacheValue = $start;
        } else {
            $cacheValue += $step;
        }

        wp_cache_set($counterName, $cacheValue, 'index_counter');

        return $cacheValue;
    }
endif;