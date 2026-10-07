# Vercel — Jobsheet New / Cafe_Najwa

Router memiliki blok khusus:

```php
if (str_starts_with($uri, '/Jobsheet New')) {
```

Jika URL hanya:

```text
/Jobsheet New
```

atau `/Jobsheet New/`, default file adalah:

```text
/Jobsheet New/index.php
```

## File yang dilayani

- PHP → `require`
- CSS → `readfile()` + `text/css`
- JS → `readfile()` + `application/javascript`
- gambar → MIME type sesuai extension

## Kenapa ada blok khusus?

Karena nama folder mengandung spasi dan project memiliki struktur master/transaksi/laporan. Router perlu memetakan URL tersebut ke folder yang benar.

Konsepnya:

```text
/Jobsheet New/master/...
        ↓
$basePath . '/Jobsheet New' . $relativePath
```
