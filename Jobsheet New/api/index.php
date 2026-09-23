<?php

$path = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$path = urldecode($path);

$basePath = dirname(__DIR__);


/*
|--------------------------------------------------------------------------
| JOBSHEET NEW
|--------------------------------------------------------------------------
*/

if (str_starts_with($path, '/Jobsheet New')) {

    $relativePath = substr(
        $path,
        strlen('/Jobsheet New')
    );

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet New' . $relativePath;


    /*
    |--------------------------------------------------------------------------
    | PHP
    |--------------------------------------------------------------------------
    */

    if (
        pathinfo($file, PATHINFO_EXTENSION) === 'php' &&
        is_file($file)
    ) {
        require $file;
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | CSS
    |--------------------------------------------------------------------------
    */

    if (
        pathinfo($file, PATHINFO_EXTENSION) === 'css' &&
        is_file($file)
    ) {
        header('Content-Type: text/css; charset=UTF-8');

        readfile($file);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | JAVASCRIPT
    |--------------------------------------------------------------------------
    */

    if (
        pathinfo($file, PATHINFO_EXTENSION) === 'js' &&
        is_file($file)
    ) {
        header('Content-Type: application/javascript; charset=UTF-8');

        readfile($file);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */

    $mimeTypes = [
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico'  => 'image/x-icon'
    ];

    $extension = strtolower(
        pathinfo($file, PATHINFO_EXTENSION)
    );

    if (
        isset($mimeTypes[$extension]) &&
        is_file($file)
    ) {
        header(
            'Content-Type: ' .
            $mimeTypes[$extension]
        );

        readfile($file);

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| FILE PHP LAINNYA
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


/*
|--------------------------------------------------------------------------
| 404
|--------------------------------------------------------------------------
*/

http_response_code(404);

echo "404 - Halaman tidak ditemukan.";