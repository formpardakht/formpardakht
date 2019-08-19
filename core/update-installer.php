<?php

ini_set('max_execution_time', '3000');

$dirs = scandir(__DIR__ . '/tmp');
if (count($dirs) > 2) {
    $src = __DIR__ . '/tmp/' . $dirs[2];
    $dst = __DIR__;
}

function delete_dir($dirPath)
{
    if (file_exists($dirPath)) {
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '{,.}[!.,!..]*', GLOB_MARK | GLOB_BRACE);

        foreach ($files as $file) {
            if (is_dir($file)) {
                delete_dir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}

function recurse_copy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..') && ($file != 'themes') && ($file != 'plugins')) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

copy(__DIR__ . '/core/config.php', __DIR__ . '/config.php');
delete_dir(__DIR__ . '/core');
recurse_copy($src, $dst);
copy(__DIR__ . '/config.php', __DIR__ . '/core/config.php');

if ($_GET['finishUrl']) {
    header('location: ' . $_GET['finishUrl']);
} else {
    header('location: ' . '/admin/update/finish');
}
