# Security Checklist — Jobsheet 11

## 1. Informasi Pengujian

**Nama Project:** Cafe_Najwa  
**Jobsheet:** 11 — Security  
**Lingkungan Pengujian:** Localhost  
**Server:** PHP Built-in Server  
**Database:** PostgreSQL  
**URL Pengujian:** `http://localhost:8000/Jobsheet11/`

---

## 2. Tujuan

Jobsheet 11 berfokus pada penerapan dan pengujian keamanan pada aplikasi web. Keamanan yang diterapkan meliputi perlindungan terhadap Cross-Site Request Forgery (CSRF), Cross-Site Scripting (XSS), Session Fixation, SQL Injection, keamanan password, authentication, dan keamanan database.

Tujuan dari penerapan keamanan ini adalah:

1. Melindungi request POST dari serangan CSRF.
2. Mencegah input berbahaya dieksekusi sebagai HTML atau JavaScript.
3. Mengganti session ID setelah proses login berhasil.
4. Mencegah manipulasi query menggunakan SQL Injection.
5. Melindungi password pengguna menggunakan hashing.
6. Membatasi akses halaman yang membutuhkan autentikasi.
7. Menjaga keamanan koneksi dan integritas database.

---

# 3. CSRF Protection

## 3.1 Pengertian

Cross-Site Request Forgery (CSRF) merupakan serangan yang memanfaatkan session pengguna untuk mengirimkan request tanpa persetujuan pengguna.

Untuk mencegah serangan tersebut, aplikasi menggunakan CSRF token pada form yang melakukan request POST.

---

## 3.2 Implementasi

File yang digunakan:

```text
includes/csrf.php
```

Fungsi utama yang digunakan:

```text
csrf_token()
csrf_field()
csrf_verify()
```

CSRF token dibuat menggunakan:

```php
random_bytes(32)
```

Token kemudian disimpan di dalam session pengguna.

Perbandingan token dilakukan menggunakan:

```php
hash_equals()
```

sehingga token yang diterima harus sesuai dengan token yang tersimpan pada session.

---

## 3.3 Penerapan pada Form

CSRF token ditambahkan pada form menggunakan:

```php
<?= csrf_field(); ?>
```

Contoh hasil HTML:

```html
<input type="hidden" name="csrf_token" value="...">
```

Token tersebut akan dikirim bersama request POST.

---

## 3.4 Validasi CSRF

Pada file proses, token diverifikasi menggunakan:

```php
csrf_verify();
```

Apabila token tidak tersedia, kosong, atau tidak sesuai dengan token yang terdapat pada session, sistem akan menghentikan request dan memberikan response HTTP 403.

Pesan yang diberikan sistem:

```text
CSRF token tidak valid.
```

---

## 3.5 Modul yang Menggunakan CSRF Protection

### Master Data

- [x] Kategori
- [x] Menu
- [x] Pelanggan
- [x] Meja

### Transaksi

- [x] Pesanan
- [x] Pembayaran

---

## 3.6 Pengujian CSRF

Pengujian dilakukan dengan cara mengubah nilai CSRF token pada form menjadi nilai yang tidak valid melalui Developer Tools.

Contoh token yang digunakan saat pengujian:

```text
SALAH
```

Kemudian form dikirim kembali ke server.

### Hasil

Sistem menolak request dan menampilkan:

```text
CSRF token tidak valid.
```

Data tidak berhasil diproses.

### Kesimpulan

CSRF Protection berhasil diterapkan dan request dengan token yang tidak valid berhasil ditolak.

**Status: BERHASIL**

---

# 4. XSS Protection

## 4.1 Pengertian

Cross-Site Scripting (XSS) merupakan kerentanan keamanan yang terjadi ketika input pengguna dapat dieksekusi sebagai HTML atau JavaScript oleh browser.

Untuk mencegah XSS, output dari input pengguna harus dilakukan escaping sebelum ditampilkan.

---

## 4.2 Implementasi

Aplikasi menyediakan helper:

```text
includes/helpers.php
```

Helper tersebut memiliki fungsi:

```php
function e($value): string
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
```

Fungsi `e()` digunakan untuk mengubah karakter khusus HTML menjadi bentuk yang aman untuk ditampilkan.

---

## 4.3 Pengujian XSS

Pengujian dilakukan pada fitur Kategori.

Input pengujian:

```html
<script>alert('XSS')</script>
```

Input tersebut dimasukkan ke dalam form kemudian disimpan.

### Hasil

Input ditampilkan sebagai teks:

```html
<script>alert('XSS')</script>
```

dan tidak menghasilkan pop-up JavaScript.

Script tidak dieksekusi oleh browser.

### Kesimpulan

Input JavaScript berhasil diperlakukan sebagai teks sehingga XSS tidak berhasil dieksekusi.

**Status: BERHASIL**

---

# 5. Session Fixation Protection

## 5.1 Pengertian

Session Fixation merupakan serangan yang dapat terjadi apabila session ID yang digunakan sebelum autentikasi tetap digunakan setelah pengguna berhasil login.

Untuk mencegah hal tersebut, session ID harus diperbarui setelah autentikasi berhasil.

---

## 5.2 Implementasi

Pada proses login digunakan:

```php
session_regenerate_id(true);
```

Kode tersebut dijalankan setelah username dan password berhasil diverifikasi.

Contoh:

```php
if (!$user || !password_verify($password, $user['password'])) {
    header("Location: login.php?pesan=gagal");
    exit;
}

session_regenerate_id(true);

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['nama'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];
```

---

## 5.3 Pengujian Session Fixation

Pengujian dilakukan dengan membandingkan nilai `PHPSESSID` sebelum dan sesudah login.

Lokasi pemeriksaan:

```text
Developer Tools
→ Application
→ Cookies
→ http://localhost:8000
```

### Hasil

Session ID sebelum login berbeda dengan session ID setelah login berhasil.

Contoh:

```text
Sebelum login:
PHPSESSID = nilai A

Setelah login:
PHPSESSID = nilai B
```

Nilai A dan B berbeda.

### Kesimpulan

Session ID berhasil diperbarui setelah login sehingga perlindungan terhadap Session Fixation telah berjalan.

**Status: BERHASIL**

---

# 6. SQL Injection Protection

## 6.1 Pengertian

SQL Injection merupakan serangan yang terjadi ketika input pengguna dapat memanipulasi struktur query SQL.

Untuk mencegah SQL Injection, aplikasi menggunakan prepared statement dan parameter binding.

---

## 6.2 Implementasi

Query database menggunakan:

```php
$pdo->prepare()
```

Kemudian nilai pengguna dikirim melalui parameter:

```php
$stmt->execute([
    ':parameter' => $value
]);
```

Contoh pada pencarian:

```php
$stmt = $pdo->prepare("
    SELECT *
    FROM kategori
    WHERE nama_kategori ILIKE :keyword
");

$stmt->execute([
    ':keyword' => '%' . $keyword . '%'
]);
```

Input pengguna tidak digabungkan langsung ke dalam query SQL.

---

# 7. Pengujian SQL Injection pada Pencarian

## 7.1 Input Pengujian

Pada fitur pencarian Kategori digunakan input:

```text
' OR '1'='1
```

Input tersebut dimasukkan ke dalam kolom pencarian.

---

## 7.2 Hasil Pengujian

Sistem tidak menganggap input tersebut sebagai bagian dari perintah SQL.

Hasil yang ditampilkan:

```text
Belum ada kategori
```

Sistem tidak menampilkan seluruh data kategori dan tidak menghasilkan error SQL.

### Kesimpulan

Prepared statement berhasil mencegah input tersebut digunakan untuk memanipulasi query SQL.

**Status: BERHASIL**

---

# 8. Pengujian SQL Injection pada Login

## 8.1 Input Pengujian

Username:

```text
' OR '1'='1
```

Password:

```text
' OR '1'='1
```

---

## 8.2 Hasil Pengujian

Sistem menolak proses login dan menampilkan:

```text
Username atau password salah.
```

Pengguna tidak dapat masuk ke dashboard menggunakan input tersebut.

### Kesimpulan

Input SQL Injection tidak dapat digunakan untuk melewati proses autentikasi.

**Status: BERHASIL**

---

# 9. Password Security

## 9.1 Tujuan

Password pengguna tidak boleh disimpan dalam bentuk plaintext.

Aplikasi menggunakan password hashing untuk menyimpan password pengguna.

---

## 9.2 Implementasi

Password diproses menggunakan:

```php
password_hash()
```

Pada saat login, password diverifikasi menggunakan:

```php
password_verify()
```

Contoh:

```php
if (!$user || !password_verify($password, $user['password'])) {
    header("Location: login.php?pesan=gagal");
    exit;
}
```

Dengan mekanisme tersebut, password asli pengguna tidak perlu disimpan dalam bentuk plaintext.

### Kesimpulan

Password telah menggunakan mekanisme hashing dan verification.

**Status: BERHASIL**

---

# 10. Authentication

## 10.1 Tujuan

Authentication digunakan untuk memastikan hanya pengguna yang telah login yang dapat mengakses halaman yang membutuhkan autentikasi.

---

## 10.2 Implementasi

Informasi pengguna yang telah berhasil login disimpan dalam session:

```php
$_SESSION['user_id']
$_SESSION['user_name']
$_SESSION['username']
$_SESSION['role']
```

Halaman yang membutuhkan autentikasi menggunakan:

```text
includes/auth.php
```

Pengguna yang belum login tidak dapat mengakses halaman yang dilindungi.

---

## 10.3 Pengujian Login

### Login dengan data benar

Pengguna dapat masuk ke dashboard setelah username dan password yang benar dimasukkan.

### Login dengan data salah

Sistem menampilkan:

```text
Username atau password salah.
```

Pengguna tidak dapat masuk ke dashboard.

### Kesimpulan

Authentication berjalan sesuai dengan yang diharapkan.

**Status: BERHASIL**

---

# 11. Logout

## 11.1 Tujuan

Logout digunakan untuk mengakhiri session pengguna setelah selesai menggunakan aplikasi.

---

## 11.2 Pengujian

Pengguna melakukan logout melalui fitur Logout.

Setelah logout, session pengguna diakhiri dan pengguna diarahkan kembali ke halaman login.

### Kesimpulan

Fitur logout berjalan sesuai dengan yang diharapkan.

**Status: BERHASIL**

---

# 12. Database Security

## 12.1 Environment Variable

Informasi koneksi database disimpan menggunakan environment variable.

Variabel yang digunakan:

```text
DB_HOST
DB_PORT
DB_NAME
DB_USER
DB_PASSWORD
```

Informasi sensitif database tidak ditulis langsung pada source code utama.

---

## 12.2 Prepared Statement

Operasi database menggunakan prepared statement.

Contoh:

```php
$stmt = $pdo->prepare("
    DELETE FROM menu
    WHERE id = :id
");

$stmt->execute([
    ':id' => $id
]);
```

Prepared statement digunakan untuk memisahkan query SQL dengan data yang berasal dari pengguna.

---

## 12.3 Foreign Key

Database menggunakan foreign key untuk menjaga integritas hubungan antar tabel.

Contohnya, Menu yang masih digunakan dalam transaksi tidak dapat dihapus secara sembarangan apabila masih memiliki relasi dengan detail pesanan.

Hal tersebut mencegah data transaksi menjadi tidak konsisten.

### Kesimpulan

Database menggunakan mekanisme yang membantu menjaga keamanan dan integritas data.

**Status: BERHASIL**

---

# 13. Hasil Pengujian Keseluruhan

| No. | Pengujian | Hasil |
|---|---|---|
| 1 | CSRF Protection | ✅ Berhasil |
| 2 | XSS Protection | ✅ Berhasil |
| 3 | Session Fixation Protection | ✅ Berhasil |
| 4 | SQL Injection pada Pencarian | ✅ Berhasil |
| 5 | SQL Injection pada Login | ✅ Berhasil |
| 6 | Password Security | ✅ Berhasil |
| 7 | Authentication | ✅ Berhasil |
| 8 | Logout | ✅ Berhasil |
| 9 | Environment Variable | ✅ Berhasil |
| 10 | Prepared Statement | ✅ Berhasil |
| 11 | Foreign Key / Data Integrity | ✅ Berhasil |

---

# 14. Checklist Keamanan

## CSRF Protection

- [x] CSRF token dibuat secara acak.
- [x] Token disimpan pada session.
- [x] Token ditambahkan ke dalam form.
- [x] Token diverifikasi pada request POST.
- [x] `hash_equals()` digunakan untuk validasi token.
- [x] Request dengan token tidak valid ditolak.
- [x] Master Data telah dilindungi.
- [x] Transaksi telah dilindungi.

## XSS Protection

- [x] Output pengguna dilakukan escaping.
- [x] `htmlspecialchars()` digunakan.
- [x] Helper `e()` tersedia.
- [x] Input JavaScript tidak dieksekusi.

## Session Security

- [x] Session digunakan untuk authentication.
- [x] Session ID diperbarui setelah login.
- [x] `session_regenerate_id(true)` digunakan.
- [x] Logout mengakhiri session pengguna.

## SQL Injection Protection

- [x] Prepared statement digunakan.
- [x] Parameter binding digunakan.
- [x] Input pengguna tidak digabungkan langsung ke query SQL.
- [x] Fitur pencarian diuji menggunakan input SQL Injection.
- [x] Fitur login diuji menggunakan input SQL Injection.

## Password Security

- [x] Password menggunakan hashing.
- [x] `password_hash()` digunakan.
- [x] `password_verify()` digunakan.
- [x] Password plaintext tidak digunakan untuk verifikasi.

## Authentication

- [x] Login tersedia.
- [x] Login dengan data yang salah ditolak.
- [x] Halaman yang membutuhkan login dilindungi.
- [x] Informasi pengguna disimpan dalam session.
- [x] Logout tersedia.

## Database Security

- [x] Kredensial database menggunakan environment variable.
- [x] Prepared statement digunakan.
- [x] Parameter binding digunakan.
- [x] Foreign key digunakan.
- [x] Integritas data dijaga.

---

# 15. Dokumentasi Bukti Pengujian

Dokumentasi screenshot yang dapat disertakan pada laporan:

### Bukti 1 — CSRF Protection

Screenshot hasil pengujian token CSRF yang telah diubah menjadi nilai tidak valid.

Hasil:
```text
CSRF token tidak valid.
```

---

### Bukti 2 — XSS Protection

Screenshot input:

```html
<script>alert('XSS')</script>
```

yang ditampilkan sebagai teks dan tidak menghasilkan pop-up.

---

### Bukti 3 — Session Fixation Protection

Screenshot perbandingan `PHPSESSID` sebelum dan sesudah login yang menunjukkan bahwa session ID berubah.

---

### Bukti 4 — SQL Injection pada Pencarian

Screenshot input:

```text
' OR '1'='1
```

pada fitur pencarian dan hasil:

```text
Belum ada kategori
```

---

### Bukti 5 — SQL Injection pada Login

Screenshot pengujian login menggunakan:

```text
Username : ' OR '1'='1
Password : ' OR '1'='1
```

dengan hasil:

```text
Username atau password salah.
```

---

# 16. Kesimpulan

Berdasarkan implementasi dan pengujian yang telah dilakukan pada Jobsheet 11, aplikasi telah menerapkan beberapa mekanisme keamanan untuk melindungi data, autentikasi, session, input pengguna, dan database.

Hasil pengujian menunjukkan bahwa:

1. CSRF token yang tidak valid berhasil ditolak oleh sistem.
2. Input XSS tidak dieksekusi sebagai JavaScript.
3. Session ID berubah setelah proses login berhasil.
4. SQL Injection pada fitur pencarian tidak dapat memanipulasi query.
5. SQL Injection pada fitur login tidak dapat digunakan untuk melewati autentikasi.
6. Password menggunakan mekanisme hashing dan verifikasi.
7. Authentication dan logout berjalan sesuai dengan yang diharapkan.
8. Prepared statement digunakan dalam operasi database.
9. Environment variable digunakan untuk menyimpan informasi koneksi database.
10. Foreign key membantu menjaga integritas hubungan antar data.

Dengan demikian, mekanisme keamanan utama yang diterapkan pada Jobsheet 11 telah berhasil diimplementasikan dan diuji menggunakan beberapa skenario pengujian keamanan.


---

# 14. Catatan Perbaikan Sebelum Commit

- File `.env` tidak boleh di-commit. Gunakan `.env.example` sebagai template.
- Form Register menggunakan CSRF token seperti form POST lainnya.
- Dashboard Jobsheet 11 juga dilindungi `includes/auth.php`, sehingga pengguna harus login sebelum mengakses halaman utama.
