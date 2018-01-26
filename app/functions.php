<?php

if (!function_exists('env')) {

    function env(string $key, $default = ''): string
    {
        if (getenv($key)) {
            return getenv($key);
        }

        return $default;
    }

}
