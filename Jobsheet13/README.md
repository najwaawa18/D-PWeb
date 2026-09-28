# Jobsheet 13 — Deployment & Dokumentasi
## Cafe_Najwa

### Sub-CPMK
Mendeploy dan mendokumentasikan aplikasi yang telah dikembangkan.

---

## 1. Deskripsi Project

Cafe_Najwa merupakan aplikasi web Sistem Informasi Manajemen Cafe yang dikembangkan secara bertahap mulai dari Jobsheet 8 sampai Jobsheet 12.

Aplikasi digunakan untuk mengelola kategori, menu, pelanggan, meja, pesanan, detail pesanan, pembayaran, serta laporan transaksi. Sistem juga dilengkapi autentikasi pengguna dan mekanisme keamanan.

## 2. Perkembangan Project

| Jobsheet | Pengembangan |
|---|---|
| JS 8 | Implementasi awal aplikasi Cafe_Najwa |
| JS 9 | CRUD, pencarian, dan pagination |
| JS 10 | Pengembangan transaksi dan integrasi database |
| JS 11 | Implementasi keamanan aplikasi |
| JS 12 | Integrasi transaksi, stok, pembayaran, dan meja |
| JS 13 | Deployment dan dokumentasi aplikasi |

JS13 merupakan tahap finalisasi dokumentasi dan deployment dari aplikasi Cafe_Najwa yang telah dikembangkan pada Jobsheet sebelumnya.

## 3. Teknologi

- HTML5
- CSS3
- JavaScript
- PHP Native
- PostgreSQL
- PDO_PGSQL
- Supabase PostgreSQL
- Vercel

## 4. Fitur Sistem

### Master Data
- Kategori
- Menu
- Pelanggan
- Meja

### Transaksi
- Pembuatan pesanan
- Detail pesanan
- Pengelolaan stok menu
- Pembayaran
- Status pesanan
- Status meja
- Pengosongan meja setelah pelanggan selesai

### Laporan
- Laporan penjualan
- Laporan pelanggan
- Laporan menu terlaris

### Keamanan
- Login dan logout
- Password hashing
- CSRF Protection
- XSS Protection
- SQL Injection Protection
- Session Fixation Protection

## 5. Alur Transaksi

```text
Pilih meja
    ↓
Buat pesanan
    ↓
Meja = Terisi
    ↓
Pesanan = Proses
    ↓
Pembayaran
    ↓
Pembayaran = Lunas
    ↓
Pesanan tetap Proses
    ↓
Makanan datang
    ↓
Pesanan = Selesai
    ↓
Pelanggan selesai makan
    ↓
Kosongkan meja
    ↓
Meja = Tersedia
```

Pembayaran Lunas tidak langsung membuat pesanan menjadi Selesai. Meja juga tetap berstatus Terisi sampai pelanggan selesai makan dan meja dikosongkan.

## 6. Database

Database yang digunakan adalah PostgreSQL dengan database `Cafe_Najwa`.

Entitas utama:
- users
- kategori
- menu
- pelanggan
- meja
- pesanan
- detail_pesanan
- pembayaran

## 7. Deployment

Aplikasi Cafe_Najwa menggunakan Vercel sebagai platform deployment dan Supabase PostgreSQL sebagai database. Credential database disimpan melalui environment variable dan tidak disimpan di repository.

### URL Deployment

Isi dengan URL Cafe_Najwa yang aktif pada Vercel. URL yang digunakan saat pengembangan dapat dituliskan di sini.

```text
[URL Vercel Cafe_Najwa]
```

## 8. Struktur Project

```text
Cafe_Najwa/
├── assets/
├── auth/
├── config/
├── docs/
├── includes/
├── layout/
├── laporan/
├── master/
│   ├── kategori/
│   ├── menu/
│   ├── pelanggan/
│   └── meja/
├── sql/
├── transaksi/
│   ├── pembayaran/
│   └── pesanan/
└── index.php
```

## 9. Konfigurasi Database

Pada lingkungan lokal, konfigurasi database menggunakan environment variable atau file `.env` lokal.

```text
DB_HOST=...
DB_PORT=...
DB_NAME=Cafe_Najwa
DB_USER=...
DB_PASSWORD=...
```

File `.env` yang berisi credential tidak diunggah ke repository.

## 10. Pengujian

Pengujian final mencakup:

| Pengujian | Hasil |
|---|---|
| Login valid | Diuji |
| Login tidak valid | Diuji |
| CRUD kategori | Diuji |
| CRUD menu | Diuji |
| CRUD pelanggan | Diuji |
| CRUD meja | Diuji |
| Membuat pesanan | Diuji |
| Pengurangan stok | Diuji |
| Stok tidak mencukupi | Diuji |
| Pembayaran | Diuji |
| Status pesanan | Diuji |
| Status meja | Diuji |
| Pengosongan meja | Diuji |
| CSRF Protection | Diuji |
| XSS Protection | Diuji |
| SQL Injection | Diuji |
| Session Fixation | Diuji |

## 11. Dokumentasi Keamanan

Mekanisme keamanan yang digunakan meliputi CSRF Token, output escaping dengan `htmlspecialchars()`, prepared statement PDO, password hashing, `password_verify()`, dan `session_regenerate_id(true)`.

## 12. Dokumentasi Pendukung

Dokumentasi tambahan tersedia pada folder `docs/`, seperti dokumentasi deployment, manual pengguna, dan testing.

## 13. Kesimpulan

Cafe_Najwa dikembangkan secara bertahap mulai dari Jobsheet 8 hingga Jobsheet 12. Setiap tahap menambahkan pengembangan pada pengelolaan data, transaksi, keamanan, serta integrasi sistem.

Pada Jobsheet 13 dilakukan deployment dan dokumentasi sebagai tahap finalisasi aplikasi sebelum digunakan sebagai hasil akhir project.
