# Jobsheet 12 — Integrasi Transaksi Cafe_Najwa

Jobsheet 12 merupakan lanjutan langsung dari **Jobsheet 11 Cafe_Najwa**.
Seluruh modul dan keamanan Jobsheet 11 dipertahankan. Perubahan utama berfokus pada integrasi front-end dan back-end transaksi.

## Perubahan dari Jobsheet 11

- Sistem tetap menggunakan database **Cafe_Najwa**.
- Modul Kategori, Menu, Pelanggan, Meja, Pesanan, Pembayaran, dan Laporan tetap dipertahankan.
- Keamanan JS11 tetap dipertahankan: CSRF, XSS, session fixation protection, prepared statement, dan autentikasi.
- Pesanan sekarang benar-benar memengaruhi **stok Menu**.
- Penambahan dan perubahan pesanan memakai **database transaction**.
- Stok menu dikunci dengan `SELECT ... FOR UPDATE` sebelum dipakai.
- Jika proses gagal, seluruh perubahan di-rollback.
- Jika pesanan aktif dihapus atau diedit, stok lama dikembalikan terlebih dahulu.
- Pesanan berstatus `Dibatalkan` tidak mengambil stok.
- Pembayaran `Lunas` otomatis mengubah status pesanan menjadi `Selesai`.
- Pembayaran dihapus atau menjadi `Belum Lunas` membuat pesanan kembali ke `Proses` (kecuali sudah `Dibatalkan`).
- Dashboard mengambil angka langsung dari database.
- Ditambahkan data uji yang tersusun untuk mempermudah pengujian.

## Struktur tambahan JS12

```text
sql/
├── 03_integrasi_transaksi.sql
└── 04_data_uji.sql
```

## Database

Tidak membuat database baru. Tetap gunakan database **Cafe_Najwa** yang sama seperti Jobsheet 11.

Jalankan:

```bash
psql -d Cafe_Najwa -f sql/03_integrasi_transaksi.sql
psql -d Cafe_Najwa -f sql/04_data_uji.sql
```

Jika memakai Supabase/DBeaver, jalankan isi kedua file SQL tersebut pada database Cafe_Najwa.

## Data uji

Data uji menyediakan:

- 8 menu
- 6 pelanggan
- beberapa meja dari database utama
- 3 pesanan contoh:
  - `PSN-001` → Selesai + Lunas
  - `PSN-002` → Proses
  - `PSN-003` → Dibatalkan
- 1 pembayaran contoh untuk `PSN-001`

## Skenario pengujian JS12

### 1. Tambah pesanan

1. Buka Menu dan catat stok salah satu menu.
2. Buka **Pesanan → Tambah Pesanan**.
3. Pilih pelanggan, meja, menu, dan jumlah.
4. Simpan.
5. Kembali ke Menu.
6. Pastikan stok berkurang sesuai jumlah yang dipesan.
7. Cek Dashboard dan Pesanan.

### 2. Uji stok tidak cukup

Masukkan jumlah pesanan lebih besar daripada stok menu.

Hasil yang diharapkan:

- pesanan tidak tersimpan;
- stok tidak berubah;
- transaction di-rollback.

### 3. Uji pembayaran

1. Pilih pesanan berstatus `Proses`.
2. Tambahkan pembayaran dengan status `Lunas`.
3. Buka Pesanan.
4. Status pesanan harus berubah menjadi `Selesai`.

### 4. Uji penghapusan pesanan

1. Catat stok menu.
2. Hapus pesanan aktif yang memiliki detail menu.
3. Buka Menu.
4. Stok harus kembali seperti sebelum pesanan dibuat.

### 5. Uji rollback

Jika salah satu detail pesanan gagal diproses, seluruh transaksi harus dibatalkan sehingga tidak ada pesanan/detail/stok yang tertinggal setengah jalan.

## Catatan

Validasi bisnis tambahan seperti pembatasan pemesanan berdasarkan kondisi tertentu dapat dikembangkan sebagai tugas mandiri. Implementasi utama JS12 berfokus pada integrasi transaksi, konsistensi stok, pembayaran, dan transaction database.
