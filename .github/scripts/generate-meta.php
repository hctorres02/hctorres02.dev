<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$index = "{$root}/dist/index.html";
$indexContent = file_get_contents($index);
$manifest = "{$root}/dist/manifest.json";
$manifestContent = file_get_contents($manifest);
$profile = json_decode(
    file_get_contents("{$root}/profile.json"),
    flags: JSON_THROW_ON_ERROR,
    associative: true
);

foreach ($profile as $key => $value) {
    $key = strtoupper("profile_{$key}");

    $indexContent = str_replace(
        $key,
        $value,
        $indexContent
    );

    $manifestContent = str_replace(
        $key,
        $value,
        $manifestContent
    );
}

file_put_contents($index, $indexContent);
file_put_contents($manifest, $manifestContent);
