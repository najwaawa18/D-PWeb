<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$path = urldecode($path);

$path = strtok($path, '?');

$basePath = dirname(__DIR__);

$file = realpath($basePath . $path);


// Jika file PHP yang diminta memang ada
if (
    $file &&
    str_starts_with($file, $basePath) &&
    is_file($file) &&
    pathinfo($file, PATHINFO_EXTENSION) === 'php'
) {
    require $file;
    exit;
}


// Jika URL utama
if ($path === '/' || $path === '') {
    require $basePath . '/index.php';
    exit;
}


// Jika halaman tidak ditemukan
http_response_code(404);

echo "404 - Halaman tidak ditemukan.";