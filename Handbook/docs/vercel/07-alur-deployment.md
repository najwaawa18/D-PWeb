# Vercel — Alur Deployment dari Browser sampai File

Misalnya browser meminta:

```text
/Jobsheet10/master/menu/index.php
```

Alurnya:

```text
Browser
  ↓
Vercel menerima request
  ↓
vercel.json mencocokkan route
  ↓
api/index.php
  ↓
REQUEST_URI dibaca
  ↓
router mengenali /Jobsheet10
  ↓
relative path = /master/menu/index.php
  ↓
basePath + /Jobsheet10 + relative path
  ↓
file ditemukan
  ↓
extension = php
  ↓
require $file
  ↓
HTML response
  ↓
Browser menampilkan halaman
```

Untuk CSS/JS, router tidak `require` file sebagai PHP. Router mengirim isi file dengan Content-Type yang sesuai.

## 404

Jika file tidak ditemukan oleh route yang relevan dan fallback PHP juga gagal:

```php
http_response_code(404);
echo "404 - Halaman tidak ditemukan.";
```
