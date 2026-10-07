# Vercel — `api/index.php` sebagai Router

## Membaca URL

Pola awal router:

```php
$uri = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$uri = urldecode($uri);
$basePath = dirname(__DIR__);
```

### Penjelasan

- `$_SERVER['REQUEST_URI']` berisi URI request.
- `parse_url(..., PHP_URL_PATH)` mengambil bagian path tanpa query string.
- `urldecode()` mengubah encoding URL kembali menjadi karakter biasa.
- `dirname(__DIR__)` mendapatkan parent directory dari folder `api` sehingga dapat digunakan sebagai root project.

## Contoh

Request:

```text
/Jobsheet10/master/menu/index.php
```

Router mengambil bagian path Jobsheet10, membangun lokasi file, lalu memeriksa apakah file tersebut benar-benar ada.
