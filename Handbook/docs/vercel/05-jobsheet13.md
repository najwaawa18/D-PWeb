# Vercel — Jobsheet 13

Jobsheet 13 mempunyai sedikit perbedaan karena deployment/dokumentasinya melayani lebih banyak tipe file.

Extension yang ditangani:

- `.html`
- `.css`
- `.js`
- `.md`
- gambar

Contoh HTML:

```php
if ($extension === 'html') {
    header('Content-Type: text/html; charset=UTF-8');
    readfile($file);
    exit;
}
```

Markdown dikirim sebagai plain text:

```php
if ($extension === 'md') {
    header('Content-Type: text/plain; charset=UTF-8');
    readfile($file);
    exit;
}
```

Jika request `/Jobsheet13` tidak memiliki path tambahan, default-nya adalah:

```text
/Jobsheet13/index.html
```
