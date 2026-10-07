# Vercel — Router Jobsheet 7–12

Jobsheet 7 sampai 12 ditangani dengan pola yang mirip:

```text
cek prefix URL
   ↓
ambil relative path
   ↓
kalau kosong → index.php
   ↓
bangun path file
   ↓
is_file()?
   ↓
cek extension
   ├─ php → require
   ├─ css → readfile + Content-Type
   ├─ js  → readfile + Content-Type
   └─ image → readfile + MIME
```

## `str_starts_with`

Contoh pola:

```php
if (str_starts_with($uri, '/Jobsheet10')) {
```

Fungsi ini mengecek apakah string URI diawali prefix tertentu.

## Relative path

```php
$relativePath = substr(
    $uri,
    strlen('/Jobsheet10')
);
```

`substr()` mengambil bagian setelah prefix Jobsheet10.

Jika URL hanya `/Jobsheet10`, router menggantinya menjadi `/index.php`.
