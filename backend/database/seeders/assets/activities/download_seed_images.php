<?php

/**
 * One-time helper: downloads seed images into this folder.
 * Run: php database/seeders/assets/activities/download_seed_images.php
 */

$dir = __DIR__;
$items = [
    'chess',
    'welding',
    'carving',
    'carpentry',
    'electrical',
    'embroidery',
    'drawing',
    'sewing',
    'painting',
    'sports',
];

foreach ($items as $slug) {
    $path = $dir . DIRECTORY_SEPARATOR . $slug . '.jpg';
    $url = 'https://picsum.photos/seed/idrizovo-' . $slug . '/800/600.jpg';

    $data = @file_get_contents($url);

    if ($data === false) {
        fwrite(STDERR, "Failed to download {$slug} from {$url}\n");
        exit(1);
    }

    file_put_contents($path, $data);
    echo "Saved {$slug}.jpg\n";
}

echo "Done.\n";
