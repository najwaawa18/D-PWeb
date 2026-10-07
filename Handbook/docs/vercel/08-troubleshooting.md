# Vercel — Troubleshooting

## 1. 404

Cek:

- path URL sesuai dengan route;
- folder Jobsheet benar-benar ada;
- nama file dan extension benar;
- `is_file($file)` menghasilkan true.

## 2. CSS tidak tampil

Pastikan router mengirim:

```php
header('Content-Type: text/css');
```

dan path file CSS benar.

## 3. JavaScript tidak berjalan

Cek URL script dan response Content-Type:

```php
header('Content-Type: application/javascript');
```

## 4. PHP tampil sebagai teks

PHP harus masuk ke branch:

```php
if ($extension === 'php') {
    require $file;
    exit;
}
```

bukan dibaca dengan `readfile()` sebagai text biasa.

## 5. Path dengan spasi

`Jobsheet New` membutuhkan penanganan path yang konsisten. Source memakai `urldecode()` agar encoded URL dapat diubah kembali.
