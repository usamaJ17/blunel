<?php

if (!function_exists('theme_asset')) {
    function theme_asset($path = null): string
    {
        $themeName = env('WEB_THEME') == null ? 'default' : env('WEB_THEME');
        return asset("resources/themes/$themeName/public/$path");
    }
}

if (!function_exists('theme_root_path')) {
    function theme_root_path(): string
    {
        return env('WEB_THEME') == null ? 'default' : env('WEB_THEME');
    }
}


