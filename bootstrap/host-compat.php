<?php

/*
|--------------------------------------------------------------------------
| Replacements For Functions Disabled By The Host
|--------------------------------------------------------------------------
|
| Some shared hosts (e.g. Byet.host) list these functions in PHP's
| disable_functions. Since PHP 8, calling a disabled function is a fatal
| "Call to undefined function" error, even with the @ operator, and
| Laravel, Winter and Twig call chmod() whenever they write a cache file.
|
| Each replacement is only declared when the native function is missing,
| so this file changes nothing on hosts where they are available.
|
*/

if (!function_exists('chmod')) {
    // The host does not allow changing permissions: keep the default ones
    // and report success so cache and upload writes carry on.
    function chmod(string $filename, int $permissions): bool
    {
        return true;
    }
}

if (!function_exists('sleep')) {
    function sleep(int $seconds): int
    {
        usleep($seconds * 1000000);

        return 0;
    }
}

if (!function_exists('set_time_limit')) {
    // The host enforces its own limit, which cannot be changed.
    function set_time_limit(int $seconds): bool
    {
        return false;
    }
}
