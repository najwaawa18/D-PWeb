<?php

$path = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$path = urldecode($path);

$basePath = dirname(__DIR__);

if ($path === '/' || $path === '') {

    require $basePath . '/index.php';

    exit;
}


// Buang query string dan cari file PHP yang diminta
$file = $basePath . $path;

if (
    pathinfo($file, PATHINFO_EXTENSION) === 'php' &&
    is_file($file)
) {

    require $file;

    exit;
}


http_response_code(404);

echo "404 - Halaman tidak ditemukan.";