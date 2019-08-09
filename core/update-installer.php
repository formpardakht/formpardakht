<?php

$dirs = scandir(__DIR__ . '/tmp');
if (count($dirs) > 2) {
    $src = __DIR__ . '/tmp/' . $dirs[2];
    $dst = __DIR__;
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

recurse_copy($src, $dst);

if ($_GET['finishUrl']) {
    header('location: ' . $_GET['finishUrl']);
} else {
    header('location: ' . '/admin/update/finish');
}
