<?php

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = urldecode($uri);

/*
|--------------------------------------------------------------------------
| Tentukan file PHP yang diminta
|--------------------------------------------------------------------------
*/

$basePath = dirname(__DIR__);

/*
|--------------------------------------------------------------------------
| Jobsheet 7
|--------------------------------------------------------------------------
*/

if (str_starts_with($uri, '/Jobsheet7')) {

    $relativePath = substr($uri, strlen('/Jobsheet7'));

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet7' . $relativePath;

    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Jobsheet 8
|--------------------------------------------------------------------------
*/

if (str_starts_with($uri, '/Jobsheet8')) {

    $relativePath = substr($uri, strlen('/Jobsheet8'));

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet8' . $relativePath;

    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Jobsheet New
|--------------------------------------------------------------------------
*/

if (str_starts_with($uri, '/Jobsheet%20New')) {
    $uri = urldecode($uri);
}

if (str_starts_with($uri, '/Jobsheet New')) {

    $relativePath = substr($uri, strlen('/Jobsheet New'));

    if ($relativePath === '' || $relativePath === '/') {
        $relativePath = '/index.php';
    }

    $file = $basePath . '/Jobsheet New' . $relativePath;

    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| PHP file lainnya
|--------------------------------------------------------------------------
*/

if (pathinfo($uri, PATHINFO_EXTENSION) === 'php') {

    $file = $basePath . $uri;

    if (is_file($file)) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Tidak ditemukan
|--------------------------------------------------------------------------
*/

http_response_code(404);

echo "404 - Halaman tidak ditemukan.";