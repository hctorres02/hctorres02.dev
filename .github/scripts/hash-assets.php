<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$dist = "{$root}/dist";
$files = glob("{$dist}/*.{css,js,json}", GLOB_BRACE);
$assets = [];

foreach ($files as $file) {
    if (! is_file($file)) {
        continue;
    }

    $filename = basename($file);

    if ($filename == 'manifest.json' || preg_match('/\.[a-f0-9]{8}\.[^.]+$/i', $filename)) {
        continue;
    }

    $hash = substr(hash_file('sha256', $file), 0, 8);
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $newFilename = "{$name}.{$hash}.{$extension}";

    rename($file, "{$dist}/{$newFilename}");

    $assets[] = compact('filename', 'newFilename');
}

$index = "{$dist}/index.html";
$indexContent = file_get_contents($index);

foreach ($assets as $asset) {
    $indexContent = str_replace(
        $asset['filename'],
        $asset['newFilename'],
        $indexContent
    );
}

file_put_contents($index, $indexContent);
