<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        // Cache the settings for 24 hours to keep Larins fast
        $allSettings = Cache::remember('site_config', 86400, function () {
            // Assuming your table is named 'settings'
            // and has columns 'key' and 'value'
            return DB::table('settings')->pluck('value', 'key')->toArray();
        });

        return $allSettings[$key] ?? $default;
    }
}
