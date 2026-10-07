# Vercel — PHP, CSS, JS, dan MIME Type

Setelah menemukan file, router memeriksa extension.

## PHP

```php
if ($extension === 'php') {
    require $file;
    exit;
}
```

PHP dijalankan server-side menggunakan `require`.

## CSS

```php
if ($extension === 'css') {
    header('Content-Type: text/css');
    readfile($file);
    exit;
}
```

CSS tidak di-`require` sebagai PHP. File dibaca lalu dikirim sebagai response CSS.

## JavaScript

```php
if ($extension === 'js') {
    header('Content-Type: application/javascript');
    readfile($file);
    exit;
}
```

## Gambar

Router mempunyai mapping extension → MIME type:

```php
$mimeTypes = [
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'svg' => 'image/svg+xml',
    'webp' => 'image/webp'
];
```

## Kenapa MIME type penting?

Browser perlu tahu jenis content yang diterima agar bisa memperlakukannya sebagai CSS, JavaScript, gambar, dan sebagainya.
