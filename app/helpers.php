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
    $nl = "\n";
    return '<script type="text/ng-template" id="template-' . $name . '">' . $nl . view('ng-templates/' . $name) . '</script>';
}

function allAngularTemplates() {
    $templateFiles = array_filter(scandir(base_path('resources/views/ng-templates')), function($file) {
        return $file != "." && $file != "..";
    });
    $templateNames = array_map(function($templateFile) {
        return pathinfo($templateFile, PATHINFO_FILENAME);
    }, $templateFiles);
    return join("\n", array_map('angularTemplate', $templateNames));
}