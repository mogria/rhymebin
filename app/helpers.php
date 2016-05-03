<?php

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '') {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

function angularTemplate($name) {
    return '<script type="text/ng-template" id="template-' . $name . '">' . view('templates/' . $name) . '</script>';
}