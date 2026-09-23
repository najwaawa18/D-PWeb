<?php

$path = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$path = urldecode($path);

$basePath = dirname(__DIR__);

/*
|--------------------------------------------------------------------------
| Jobsheet New
|--------------------------------------------------------------------------
*/

if (str_starts_with($path, '/Jobsheet New')) {

    $relativePath = substr($path, strlen('/Jobsheet New'));

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet New' . $relativePath;

    if (
        pathinfo($file, PATHINFO_EXTENSION) === 'php' &&
        is_file($file)
    ) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| File PHP lainnya
|--------------------------------------------------------------------------
*/

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