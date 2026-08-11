<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$dist = "{$root}/dist";
$files = glob("{$root}/*.{html,css,js,json}", GLOB_BRACE);

mkdir($dist, 0755, true);

foreach ($files as $file) {
    if (! is_file($file)) {
        continue;
    }

    $filename = basename($file);

    copy($file, "{$dist}/{$filename}");
}
