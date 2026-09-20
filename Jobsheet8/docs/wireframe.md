# Wireframe & User Flow — SIMPUS-Mini

**Sub-CPMK:** Merancang UI/UX aplikasi (proyek)

## 1. Gambaran Umum

Halaman yang telah dibuat pada Jobsheet 1–3 tetap digunakan sebagai bagian dari sistem, yaitu:

- Beranda
- Daftar Buku
- Tambah Buku
- Daftar Anggota
- Tambah Anggota


---

## 2. Aktor Sistem

### Tamu

Tamu merupakan pengguna yang belum login. Tamu dapat:

- Melihat halaman Beranda
- Melihat daftar buku
- Melihat informasi buku yang tersedia

Tamu tidak dapat melakukan transaksi peminjaman atau pengembalian.

### Petugas

Petugas merupakan pengguna yang telah melakukan login. Petugas dapat:

- Mengakses Dashboard
- Mengelola data buku
- Mengelola data anggota
- Melakukan peminjaman buku
- Melakukan pengembalian buku
- Melihat riwayat peminjaman

---

## 3. User Flow Login

Alur login petugas dirancang sebagai berikut:

```text
[Halaman Login]
       |
       v
[Masukkan Username & Password]
       |
       v
     [Masuk]
       |
       v
[Validasi Data Login]
       |
   +---+---+
   |       |
  Gagal   Berhasil
   |       |
   v       v
[Pesan] [Dashboard]
```

Jika data login tidak sesuai, sistem menampilkan pesan kesalahan. Jika data benar, petugas diarahkan menuju Dashboard.

---

## 4. User Flow Peminjaman Buku

```text
[Petugas Login]
       |
       v
[Dashboard]
       |
       v
[Peminjaman Baru]
       |
       v
[Pilih Anggota]
       |
       v
[Pilih Buku yang Tersedia]
       |
       v
[Isi Data Peminjaman]
       |
       v
[Simpan]
       |
       v
[Transaksi Berhasil]
       |
       v
[Stok Buku Berkurang 1]
       |
       v
[Kembali ke Dashboard]
```

Buku yang memiliki stok 0 tidak dapat dipilih untuk transaksi peminjaman.

---

## 5. User Flow Pengembalian Buku

```text
[Dashboard]
       |
       v
[Pengembalian]
       |
       v
[Cari Transaksi Aktif]
       |
       v
[Pilih Transaksi]
       |
       v
[Tandai sebagai Dikembalikan]
       |
       v
[Stok Buku Bertambah 1]
       |
       v
[Kembali ke Dashboard]
```

Pengembalian dilakukan berdasarkan transaksi yang masih berstatus dipinjam.

---

## 6. Wireframe Halaman Login

```text
+------------------------------------------+
|              SIMPUS-Mini                 |
|------------------------------------------|
|                                          |
|           LOGIN PETUGAS                  |
|                                          |
|  Username                                |
|  [____________________________]          |
|                                          |
|  Password                                |
|  [____________________________]          |
|                                          |
|            [     MASUK     ]             |
|                                          |
|       Kembali ke Beranda                 |
|                                          |
+------------------------------------------+
```

### Komponen

- Logo/nama aplikasi SIMPUS-Mini
- Input username
- Input password
- Tombol Masuk
- Link kembali ke Beranda

---

## 7. Wireframe Dashboard Petugas

```text
+----------------------------------------------------------------+
| SIMPUS-Mini | Beranda | Buku | Anggota | Peminjaman | Logout   |
|----------------------------------------------------------------|
|                                                                |
|                    DASHBOARD PETUGAS                           |
|                                                                |
|  +----------------+  +----------------+  +----------------+    |
|  |   TOTAL BUKU   |  | TOTAL ANGGOTA |  |  DIPINJAM      |    |
|  |       10       |  |       7       |  |       3        |    |
|  +----------------+  +----------------+  +----------------+    |
|                                                                |
|  Aksi Cepat                                                     |
|  [ + Peminjaman Baru ]       [ Pengembalian ]                  |
|                                                                |
|  Transaksi Terbaru                                             |
|  ------------------------------------------------------------  |
|  Anggota       | Buku             | Tanggal    | Status        |
|  ------------------------------------------------------------  |
|  Siti Aminah   | Laskar Pelangi   | 01/09/26   | Dipinjam      |
|  Budi Santoso  | Bumi Manusia     | 02/09/26   | Dipinjam      |
|                                                                |
+----------------------------------------------------------------+
```

### Komponen

Dashboard menampilkan:

- Navbar
- Nama/status petugas
- Total buku
- Total anggota
- Jumlah buku yang sedang dipinjam
- Tombol Peminjaman Baru
- Tombol Pengembalian
- Tabel transaksi terbaru

---

## 8. Wireframe Form Peminjaman

```text
+------------------------------------------+
|           PEMINJAMAN BUKU                |
|------------------------------------------|
|                                          |
|  Anggota                                 |
|  [ Pilih anggota              v ]        |
|                                          |
|  Buku                                    |
|  [ Pilih buku tersedia        v ]        |
|                                          |
|  Tanggal Peminjaman                      |
|  [ 03/09/2026                 ]          |
|                                          |
|                                          |
|  [ Batal ]       [ Simpan Peminjaman ]  |
|                                          |
+------------------------------------------+
```

### Komponen

- Pilihan anggota
- Pilihan buku
- Tanggal peminjaman
- Tombol Batal
- Tombol Simpan Peminjaman

Tanggal peminjaman otomatis menggunakan tanggal saat transaksi dilakukan.

Buku dengan stok 0 tidak ditampilkan atau tidak dapat dipilih.

---

## 9. Wireframe Form Pengembalian

```text
+----------------------------------------------------------------+
|                    PENGEMBALIAN BUKU                           |
|----------------------------------------------------------------|
|                                                                |
|  Cari transaksi                                                |
|  [ Nama anggota / judul buku________________ ] [ Cari ]       |
|                                                                |
|  Transaksi Aktif                                               |
|  ----------------------------------------------------------------
|  Anggota       | Buku            | Tgl Pinjam | Aksi           |
|  ----------------------------------------------------------------
|  Siti Aminah   | Bumi Manusia    | 01/09/26   | [Kembalikan]  |
|  Budi Santoso  | Laskar Pelangi  | 02/09/26   | [Kembalikan]  |
|                                                                |
+----------------------------------------------------------------+
```

### Komponen

- Kolom pencarian
- Tombol Cari
- Tabel transaksi aktif
- Nama anggota
- Judul buku
- Tanggal peminjaman
- Tombol Kembalikan

Setelah pengembalian berhasil, stok buku akan bertambah 1.

---

## 10. Wireframe Riwayat Peminjaman Anggota

```text
+----------------------------------------------------------------+
|                 RIWAYAT PEMINJAMAN ANGGOTA                     |
|----------------------------------------------------------------|
|                                                                |
|  Anggota : Siti Aminah                                         |
|                                                                |
|  ----------------------------------------------------------------
|  Buku             | Tgl Pinjam | Tgl Kembali | Status          |
|  ----------------------------------------------------------------
|  Laskar Pelangi   | 01/07/26   | 10/07/26    | Selesai         |
|  Bumi Manusia     | 15/07/26   | -           | Dipinjam        |
|                                                                |
+----------------------------------------------------------------+
```

### Komponen

- Nama anggota
- Judul buku
- Tanggal peminjaman
- Tanggal pengembalian
- Status transaksi

Status transaksi terdiri dari:

- **Dipinjam** → buku masih dipinjam
- **Selesai** → buku sudah dikembalikan

---

## 11. Struktur Navigasi

Struktur navigasi SIMPUS-Mini dirancang sebagai berikut:

```text
                         SIMPUS-Mini
                              |
              +---------------+---------------+
              |                               |
            Tamu                           Petugas
              |                               |
       +------+-------+                    [Login]
       |              |                       |
    Beranda      Daftar Buku             Dashboard
                                             |
                         +-------------------+-------------------+
                         |          |          |        |        |
                       Buku      Anggota   Peminjaman Pengembalian Logout
                         |          |          |
                      CRUD        CRUD    Peminjaman Baru
                                             |
                                          Riwayat
```

---

## 12. Konsistensi Desain

Perancangan halaman baru tetap mempertahankan struktur dan pola
antarmuka yang telah digunakan pada Jobsheet 1–3, tetapi dilakukan
pengembangan visual dengan tema Galaxy untuk memberikan identitas
tampilan yang lebih modern dan konsisten pada seluruh halaman
SIMPUS-Mini.

Hal-hal yang dipertahankan:

- Struktur dan susunan layout halaman
- Tipografi yang mudah dibaca
- Gaya navigasi yang konsisten
- Bentuk dan fungsi tombol
- Struktur tabel
- Jarak antar elemen
- Tampilan kartu statistik
- Prinsip responsif pada berbagai ukuran layar

Hal-hal yang dikembangkan:

- Warna utama menggunakan kombinasi warna gelap dengan aksen ungu,
  biru, dan cyan
- Latar belakang menggunakan konsep visual ruang angkasa atau galaxy
- Elemen antarmuka menggunakan efek glow dan transparansi
- Kartu statistik dan panel menggunakan gaya visual modern
- Tombol dan elemen interaktif menggunakan aksen warna kosmik

Dengan demikian, halaman baru seperti Login, Dashboard, Peminjaman,
dan Pengembalian tetap menjadi bagian dari satu sistem SIMPUS-Mini,
meskipun menggunakan pengembangan visual dengan tema Galaxy.