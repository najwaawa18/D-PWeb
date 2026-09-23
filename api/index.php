<?php

$uri = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$uri = urldecode($uri);

$basePath = dirname(__DIR__);


/*
|--------------------------------------------------------------------------
| JOBSHEET 7
|--------------------------------------------------------------------------
*/

if (str_starts_with($uri, '/Jobsheet7')) {

    $relativePath = substr($uri, strlen('/Jobsheet7'));

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet7' . $relativePath;

    if (
        is_file($file) &&
        pathinfo($file, PATHINFO_EXTENSION) === 'php'
    ) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 8
|--------------------------------------------------------------------------
*/

if (str_starts_with($uri, '/Jobsheet8')) {

    $relativePath = substr($uri, strlen('/Jobsheet8'));

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet8' . $relativePath;

    if (
        is_file($file) &&
        pathinfo($file, PATHINFO_EXTENSION) === 'php'
    ) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| JOBSHEET NEW
|--------------------------------------------------------------------------
| Mencakup:
| master/
| transaksi/
| laporan/
| dan semua subfolder di dalamnya.
|--------------------------------------------------------------------------
*/

if (str_starts_with($uri, '/Jobsheet New')) {

    $relativePath = substr($uri, strlen('/Jobsheet New'));

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet New' . $relativePath;

    if (is_file($file)) {

        $extension = strtolower(
            pathinfo($file, PATHINFO_EXTENSION)
        );

        /*
         * PHP
         */
        if ($extension === 'php') {
            require $file;
            exit;
        }

        /*
         * CSS
         */
        if ($extension === 'css') {
            header('Content-Type: text/css');
            readfile($file);
            exit;
        }

        /*
         * JavaScript
         */
        if ($extension === 'js') {
            header('Content-Type: application/javascript');
            readfile($file);
            exit;
        }

        /*
         * Images
         */
        $mimeTypes = [
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'ico'  => 'image/x-icon',
            'webp' => 'image/webp'
        ];

        if (isset($mimeTypes[$extension])) {
            header('Content-Type: ' . $mimeTypes[$extension]);
            readfile($file);
            exit;
        }
    }
}


/*
|--------------------------------------------------------------------------
| PHP FILE LAINNYA
|--------------------------------------------------------------------------
*/

if (
    pathinfo($uri, PATHINFO_EXTENSION) === 'php'
) {

    $file = $basePath . $uri;

    if (is_file($file)) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| 404
|--------------------------------------------------------------------------
*/

http_response_code(404);

echo "404 - Halaman tidak ditemukan.";