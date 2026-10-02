# 03 — Security

## SQL Injection

Gunakan `prepare()` + `execute()`.

Jangan membuat query seperti:

```php
$sql = "SELECT * FROM users WHERE username = '$username'";
```

Source menggunakan placeholder seperti `:username`.

## XSS

Escape output:

```php
htmlspecialchars($value, ENT_QUOTES, 'UTF-8')
```

JS11 juga menyediakan helper `e()`.

## CSRF

Alur:

1. Session aktif.
2. Token dibuat dengan `random_bytes(32)`.
3. Token disimpan di `$_SESSION`.
4. Form memasukkan hidden input.
5. Endpoint POST memanggil `csrf_verify()`.
6. Token dibandingkan dengan `hash_equals()`.
7. Jika salah → HTTP 403.

## Password

Register menggunakan `password_hash()`.
Login menggunakan `password_verify()`.

## Session fixation

Setelah login berhasil:

```php
session_regenerate_id(true);
```
