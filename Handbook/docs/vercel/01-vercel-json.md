# Vercel — `vercel.json`

Source menggunakan:

```json
{
  "version": 2,
  "functions": {
    "api/index.php": {
      "runtime": "vercel-php@0.7.4"
    }
  }
}
```

## Runtime

`api/index.php` diperlakukan sebagai function dengan runtime PHP.

## Routes

Contoh:

```json
{
  "src": "/Jobsheet8/?$",
  "dest": "/api/index.php"
}
```

Artinya request ke path `/Jobsheet8` diarahkan ke `api/index.php`.

Ada juga pola:

```json
{
  "src": "/(.*\.php)$",
  "dest": "/api/index.php"
}
```

yang mengarahkan request berakhiran `.php` ke router.

## Jobsheet yang didaftarkan

Konfigurasi source mencakup Jobsheet 7–13 dan `/Jobsheet New`.
