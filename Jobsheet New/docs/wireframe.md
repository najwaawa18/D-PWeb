# WIREFRAME & USER FLOW
## KAFEIN — Sistem Informasi Manajemen Kafe

---

## 1. Deskripsi Sistem

KAFEIN (Sistem Informasi Manajemen Kafe) merupakan sistem informasi yang digunakan untuk membantu pengelolaan data dan aktivitas operasional kafe.

Sistem mencakup pengelolaan data master, transaksi pesanan dan pembayaran, serta penyajian laporan.

Sistem terdiri dari tiga bagian utama:

1. Master Data
2. Transaksi
3. Laporan

---

## 2. Aktor Sistem

### 2.1 Admin/Petugas

Admin atau petugas merupakan pengguna utama sistem yang bertugas mengelola data dan transaksi kafe.

Hak akses:

- Mengelola data kategori menu
- Mengelola data menu
- Mengelola data pelanggan
- Mengelola data meja
- Mengelola pesanan
- Mengelola pembayaran
- Melihat laporan

### 2.2 Pelanggan

Pelanggan merupakan pihak yang melakukan pemesanan makanan atau minuman di kafe.

Pelanggan tidak memiliki akses langsung ke sistem pengelolaan data. Data pelanggan dicatat oleh petugas ketika melakukan pemesanan.

---

## 3. Struktur Navigasi

```text
KAFEIN
│
├── Dashboard
│
├── Master Data
│   ├── Kategori
│   ├── Menu
│   ├── Pelanggan
│   └── Meja
│
├── Transaksi
│   ├── Pesanan
│   └── Pembayaran
│
└── Laporan
    ├── Penjualan
    ├── Menu Terlaris
    └── Pelanggan
```

---

# 4. User Flow

## 4.1 Alur Dashboard

```text
[Halaman Utama]
       |
       v
   [Dashboard]
       |
       +------------------+
       |        |         |
       v        v         v
   [Master] [Transaksi] [Laporan]
```

Dashboard menampilkan ringkasan informasi seperti:

- Total menu
- Total pelanggan
- Total meja
- Pesanan hari ini
- Pendapatan hari ini

---

## 4.2 Alur Pengelolaan Kategori

```text
[Dashboard]
     |
     v
[Master Data]
     |
     v
[Kategori]
     |
     +-------------------+
     |                   |
     v                   v
[Daftar Kategori]    [Tambah Kategori]
     |                   |
     |                   v
     |              [Isi Form]
     |                   |
     |                   v
     |               [Simpan]
     |                   |
     +----------> [Daftar Kategori]
```

Data kategori digunakan untuk mengelompokkan menu kafe.

Contoh:

- Kopi
- Non-Kopi
- Makanan
- Snack
- Dessert

---

## 4.3 Alur Pengelolaan Menu

```text
[Dashboard]
     |
     v
[Master Data]
     |
     v
[Menu]
     |
     +-----------------------+
     |                       |
     v                       v
[Daftar Menu]           [Tambah Menu]
     |                       |
     |                       v
     |                  [Isi Form]
     |                       |
     |                       v
     |                    [Simpan]
     |                       |
     +-----------> [Daftar Menu]
```

Data menu meliputi:

- Kode menu
- Nama menu
- Kategori
- Harga
- Stok
- Status ketersediaan

---

## 4.4 Alur Pengelolaan Pelanggan

```text
[Dashboard]
     |
     v
[Master Data]
     |
     v
[Pelanggan]
     |
     +--------------------------+
     |                          |
     v                          v
[Daftar Pelanggan]        [Tambah Pelanggan]
     |                          |
     |                          v
     |                     [Isi Form]
     |                          |
     |                          v
     |                       [Simpan]
     |                          |
     +------------> [Daftar Pelanggan]
```

Data pelanggan meliputi:

- Kode pelanggan
- Nama
- Nomor HP
- Email

---

## 4.5 Alur Pengelolaan Meja

```text
[Dashboard]
     |
     v
[Master Data]
     |
     v
[Meja]
     |
     +---------------------+
     |                     |
     v                     v
[Daftar Meja]        [Tambah Meja]
     |                     |
     |                     v
     |                [Isi Form]
     |                     |
     |                     v
     |                  [Simpan]
     |                     |
     +----------> [Daftar Meja]
```

Data meja meliputi:

- Nomor meja
- Kapasitas
- Status meja

Status meja:

- Kosong
- Terisi
- Dipesan

---

# 5. Alur Transaksi

## 5.1 Alur Pesanan

```text
[Dashboard]
     |
     v
[Transaksi]
     |
     v
[Pesanan]
     |
     v
[Tambah Pesanan]
     |
     v
[Pilih Pelanggan]
     |
     v
[Pilih Meja]
     |
     v
[Pilih Menu]
     |
     v
[Tentukan Jumlah]
     |
     v
[Hitung Subtotal]
     |
     v
[Hitung Total]
     |
     v
[Simpan Pesanan]
     |
     v
[Pesanan Berhasil]
```

### Detail Proses Pesanan

1. Petugas membuka menu Pesanan.
2. Petugas memilih pelanggan.
3. Petugas memilih meja.
4. Petugas memilih menu yang dipesan.
5. Petugas menentukan jumlah menu.
6. Sistem menghitung subtotal setiap menu.
7. Sistem menghitung total pesanan.
8. Petugas menyimpan pesanan.
9. Sistem menyimpan data pesanan dan detail pesanan.
10. Sistem memperbarui status meja.

Contoh:

```text
Pesanan P001

Pelanggan : Najwa
Meja      : M03

Menu                  Jumlah    Harga       Subtotal
-----------------------------------------------------
Cappuccino               1      18.000       18.000
French Fries             1      15.000       15.000
Chocolate Cake           1      22.000       22.000
-----------------------------------------------------
Total                                      Rp55.000
```

---

## 5.2 Alur Pembayaran

```text
[Dashboard]
     |
     v
[Transaksi]
     |
     v
[Pembayaran]
     |
     v
[Pilih Pesanan]
     |
     v
[Tampilkan Total]
     |
     v
[Pilih Metode Pembayaran]
     |
     v
[Konfirmasi Pembayaran]
     |
     v
[Simpan Pembayaran]
     |
     v
[Status = Lunas]
```

Metode pembayaran:

- Cash
- QRIS
- Debit
- E-Wallet

---

# 6. Alur Laporan

## 6.1 Laporan Penjualan

```text
[Dashboard]
     |
     v
[Laporan]
     |
     v
[Penjualan]
     |
     v
[Pilih Periode]
     |
     v
[Tampilkan Data Penjualan]
```

Laporan dapat menampilkan:

- Tanggal
- Kode pesanan
- Pelanggan
- Total
- Status pembayaran

---

## 6.2 Laporan Menu Terlaris

```text
[Dashboard]
     |
     v
[Laporan]
     |
     v
[Menu Terlaris]
     |
     v
[Pilih Periode]
     |
     v
[Tampilkan Menu Terlaris]
```

Informasi:

- Nama menu
- Jumlah terjual
- Total pendapatan

---

## 6.3 Laporan Pelanggan

```text
[Dashboard]
     |
     v
[Laporan]
     |
     v
[Pelanggan]
     |
     v
[Tampilkan Data Pelanggan]
```

Informasi:

- Nama pelanggan
- Jumlah pesanan
- Total transaksi

---

# 7. Wireframe Halaman

## 7.1 Wireframe Dashboard

```text
+----------------------------------------------------------+
| KAFEIN                         Dashboard | Master | ... |
+----------------------------------------------------------+
|                                                          |
|  Dashboard                                               |
|  Ringkasan Sistem KAFEIN                                 |
|                                                          |
|  +-------------+  +-------------+  +-------------+       |
|  | Total Menu  |  | Pelanggan   |  | Meja        |       |
|  |     25      |  |     48      |  |     10      |       |
|  +-------------+  +-------------+  +-------------+       |
|                                                          |
|  +--------------------+  +---------------------------+   |
|  | Pesanan Hari Ini   |  | Pendapatan Hari Ini       |   |
|  |        17          |  |       Rp850.000           |   |
|  +--------------------+  +---------------------------+   |
|                                                          |
|  Pesanan Terbaru                                         |
|  +----------------------------------------------------+  |
|  | Kode | Pelanggan | Meja | Total | Status          |  |
|  +----------------------------------------------------+  |
|  | P001 | Najwa     | M03  | 55.000| Lunas           |  |
|  +----------------------------------------------------+  |
|                                                          |
+----------------------------------------------------------+
```

---

## 7.2 Wireframe Daftar Menu

```text
+----------------------------------------------------------+
| KAFEIN                                                   |
+----------------------------------------------------------+
| Dashboard | Master Data | Transaksi | Laporan            |
+----------------------------------------------------------+
|                                                          |
|  Data Menu                           [ + Tambah Menu ]   |
|                                                          |
|  Cari Menu: [________________________] [Cari]            |
|                                                          |
|  +----------------------------------------------------+  |
|  | Kode | Nama | Kategori | Harga | Stok | Status    |  |
|  +----------------------------------------------------+  |
|  | M001 | Cappuccino | Kopi | 18K | 20 | Tersedia   |  |
|  | M002 | Matcha     | Non-Kopi | 20K | 15 | Tersedia| |
|  +----------------------------------------------------+  |
|                                                          |
+----------------------------------------------------------+
```

---

## 7.3 Wireframe Form Menu

```text
+----------------------------------------------------------+
| KAFEIN                                                   |
+----------------------------------------------------------+
|                                                          |
|  Tambah Menu                                             |
|                                                          |
|  Kode Menu                                               |
|  [____________________________]                           |
|                                                          |
|  Nama Menu                                               |
|  [____________________________]                           |
|                                                          |
|  Kategori                                                |
|  [ Pilih Kategori              ▼ ]                       |
|                                                          |
|  Harga                                                   |
|  [____________________________]                           |
|                                                          |
|  Stok                                                    |
|  [____________________________]                           |
|                                                          |
|  Status                                                  |
|  [ Tersedia                    ▼ ]                       |
|                                                          |
|             [Batal]       [Simpan]                       |
|                                                          |
+----------------------------------------------------------+
```

---

## 7.4 Wireframe Daftar Pesanan

```text
+----------------------------------------------------------+
| KAFEIN                                                   |
+----------------------------------------------------------+
|                                                          |
|  Data Pesanan                        [ + Pesanan Baru ]  |
|                                                          |
|  +----------------------------------------------------+  |
|  | Kode | Pelanggan | Meja | Tanggal | Total | Status | |
|  +----------------------------------------------------+  |
|  | P001 | Najwa     | M03  | 21/09   | 55K   | Selesai| |
|  | P002 | Siti      | M01  | 21/09   | 42K   | Proses | |
|  +----------------------------------------------------+  |
|                                                          |
+----------------------------------------------------------+
```

---

## 7.5 Wireframe Form Pesanan

```text
+----------------------------------------------------------+
| KAFEIN                                                   |
+----------------------------------------------------------+
|                                                          |
|  Buat Pesanan Baru                                       |
|                                                          |
|  Pelanggan                                               |
|  [ Pilih Pelanggan              ▼ ]                      |
|                                                          |
|  Meja                                                    |
|  [ Pilih Meja                   ▼ ]                      |
|                                                          |
|  Daftar Menu                                             |
|  +----------------------------------------------------+  |
|  | Menu                 | Harga     | Jumlah | Subtotal| |
|  +----------------------------------------------------+  |
|  | Cappuccino           | 18.000    | [ 1 ]  | 18.000  | |
|  | French Fries         | 15.000    | [ 1 ]  | 15.000  | |
|  +----------------------------------------------------+  |
|                                                          |
|  Total Pesanan                         Rp33.000           |
|                                                          |
|                         [Batal]       [Simpan Pesanan]   |
|                                                          |
+----------------------------------------------------------+
```

---

## 7.6 Wireframe Pembayaran

```text
+----------------------------------------------------------+
| KAFEIN                                                   |
+----------------------------------------------------------+
|                                                          |
|  Pembayaran                                              |
|                                                          |
|  Pesanan                                                 |
|  [ P001 - Najwa - Meja M03       ▼ ]                    |
|                                                          |
|  Total Tagihan                                           |
|  Rp55.000                                                |
|                                                          |
|  Metode Pembayaran                                       |
|  [ QRIS                         ▼ ]                      |
|                                                          |
|  Status                                                  |
|  [ Lunas                        ▼ ]                       |
|                                                          |
|                  [Batal]       [Bayar]                   |
|                                                          |
+----------------------------------------------------------+
```

---

# 8. Database Relationship

```text
+-------------+
|  kategori   |
+------+------+
       |
       | 1
       |
       | N
+------v------+
|    menu     |
+------+------+
       |
       | 1
       |
       | N
+------v--------------+
|  detail_pesanan     |
+----------+----------+
           |
           | N
           |
           | 1
      +----v----+
      | pesanan |
      +----+----+
           |
      +----+----------+
      |               |
      v               v
+-----------+   +-------------+
| pelanggan |   |    meja     |
+-----------+   +-------------+

      pesanan
         |
         | 1
         |
         | 1
         v
+----------------+
|   pembayaran   |
+----------------+
```

---

# 9. Struktur Database

### Tabel `kategori`

```text
id
nama_kategori
```

### Tabel `menu`

```text
id
kode_menu
nama_menu
kategori_id
harga
stok
status
```

### Tabel `pelanggan`

```text
id
kode_pelanggan
nama
no_hp
email
```

### Tabel `meja`

```text
id
nomor_meja
kapasitas
status
```

### Tabel `pesanan`

```text
id
kode_pesanan
pelanggan_id
meja_id
tanggal_pesanan
status
total
```

### Tabel `detail_pesanan`

```text
id
pesanan_id
menu_id
jumlah
harga
subtotal
```

### Tabel `pembayaran`

```text
id
pesanan_id
tanggal_bayar
total_bayar
metode_pembayaran
status
```

---

# 10. Konsistensi Desain

Perancangan halaman KAFEIN menggunakan struktur antarmuka yang konsisten pada seluruh halaman sistem.

Hal-hal yang dipertahankan:

- Struktur navigasi yang konsisten
- Tipografi yang mudah dibaca
- Bentuk tombol yang seragam
- Struktur tabel yang konsisten
- Jarak antar elemen yang teratur
- Tampilan kartu informasi pada dashboard
- Form input yang memiliki pola yang sama
- Tampilan responsif pada berbagai ukuran layar

Tema visual KAFEIN menggunakan konsep modern yang sesuai dengan identitas kafe.

Warna, ikon, tombol, tabel, kartu, dan elemen interaktif dibuat konsisten sehingga pengguna dapat berpindah antarhalaman dengan mudah.

---

# 11. Ringkasan Modul

| Modul | Fungsi |
|---|---|
| Dashboard | Menampilkan ringkasan informasi kafe |
| Kategori | Mengelola kategori menu |
| Menu | Mengelola data makanan dan minuman |
| Pelanggan | Mengelola data pelanggan |
| Meja | Mengelola data meja |
| Pesanan | Mengelola transaksi pesanan |
| Pembayaran | Mengelola pembayaran pesanan |
| Penjualan | Menampilkan laporan penjualan |
| Menu Terlaris | Menampilkan menu yang paling banyak terjual |
| Pelanggan | Menampilkan ringkasan aktivitas pelanggan |

---

# 12. Alur Utama Sistem

```text
                   KAFEIN
                      |
                      v
                  Dashboard
                      |
          +-----------+-----------+
          |           |           |
          v           v           v
       MASTER     TRANSAKSI    LAPORAN
          |           |           |
          |           |           +-- Penjualan
          |           |           +-- Menu Terlaris
          |           |           +-- Pelanggan
          |           |
          |           +-- Pesanan
          |           |      |
          |           |      +-- Detail Pesanan
          |           |
          |           +-- Pembayaran
          |
          +-- Kategori
          +-- Menu
          +-- Pelanggan
          +-- Meja
```

---

# 13. Kesimpulan

KAFEIN dirancang sebagai sistem informasi manajemen kafe yang memisahkan pengelolaan data menjadi tiga bagian utama, yaitu Master Data, Transaksi, dan Laporan.

Struktur tersebut membuat sistem lebih terorganisasi dan membedakan KAFEIN dari sistem sebelumnya. Master Data digunakan untuk mengelola data dasar, Transaksi digunakan untuk mencatat aktivitas pemesanan dan pembayaran, sedangkan Laporan digunakan untuk menyajikan informasi hasil transaksi.

Struktur sistem dapat dikembangkan secara bertahap sesuai kebutuhan pengerjaan setiap Jobsheet.