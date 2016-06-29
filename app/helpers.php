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

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param string $path
     *
     * @return string
     */
    function public_path($path = '')
    {
        return env('PUBLIC_PATH', base_path('public')).($path ? '/'.$path : $path);
    }
}

if (!function_exists('elixir')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param string $file
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    function elixir($file)
    {
        static $manifest = null;
        $buildPath = trim(env('ELIXIR_BUILD_PATH', 'build'), '/'); // Trim start & end slashes.
        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path($buildPath.'/rev-manifest.json')), true);
        }
        if (isset($manifest[$file])) {
            return '/'.$buildPath.'/'.$manifest[$file];
        }
        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}

// this function is from stackoverflow by Gordon:
// https://stackoverflow.com/questions/2637945/getting-relative-path-from-absolute-path-in-php
function getRelativePath($from, $to)
{
    // some compatibility fixes for Windows paths
    $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
    $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
    $from = str_replace('\\', '/', $from);
    $to   = str_replace('\\', '/', $to);

    $from     = explode('/', $from);
    $to       = explode('/', $to);
    $relPath  = $to;

    foreach($from as $depth => $dir) {
        // find first non-matching dir
        if($dir === $to[$depth]) {
            // ignore this directory
            array_shift($relPath);
        } else {
            // get number of remaining dirs to $from
            $remaining = count($from) - $depth;
            if($remaining > 1) {
                // add traversals up to first matching dir
                $padLength = (count($relPath) + $remaining - 1) * -1;
                $relPath = array_pad($relPath, $padLength, '..');
                break;
            } else {
                $relPath[0] = $relPath[0];
            }
        }
    }
    return implode('/', $relPath);
}

function angularTemplate($path) {
    $nl = "\n";
    $id_slug = str_replace(["\\", "/"], "-", $path);
    $id = 'id="template-' . htmlspecialchars($id_slug) . '"';
    $type = 'type="text/ng-template"';
    $renderedView = view('ng-templates/' . $path);
    return "<script $type $id>\n" . $renderedView . "\n</script>";
}

function allAngularTemplates() {
    // read all files in templates folder for angular in order to render them as a script tag onto the page
    $angularTemplatePath = base_path('resources/views/ng-templates');
    $iteratorFlags = \FilesystemIterator::SKIP_DOTS | \FileSystemIterator::CURRENT_AS_FILEINFO;
    $fileIterator = new \RecursiveDirectoryIterator($angularTemplatePath, $iteratorFlags);
    $fileIterator = new \RecursiveIteratorIterator($fileIterator);
    $files = array_values(iterator_to_array($fileIterator));

    // only grab .html files, ignore other files which may be in the folder
    $templateFiles = array_filter($files, function($file) {
        return $file->isFile() && $file->getExtension() === "html"; // is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === "html";
    });

    // get relative path so they can be passed to view()
    $templateNames = array_map(function($templateFile) use ($angularTemplatePath) {
        return getRelativePath($angularTemplatePath, $templateFile->getPath()) . $templateFile->getBasename(".html");
    }, $templateFiles);

    // sort the files so they come out deterministically (and not based on and inode number or something like that)
    sort($templateNames, SORT_STRING);
    return "\n" . join("\n", array_map('angularTemplate', $templateNames));
}
