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
- Saat pesanan dibuat, meja otomatis berubah menjadi `Terisi`. Meja yang masih digunakan tidak dapat dipilih untuk pesanan lain.
- Pembayaran `Lunas` hanya mencatat pembayaran; status pesanan tetap mengikuti proses pelayanan.
- Status pesanan `Proses` digunakan saat makanan masih diproses. Setelah makanan datang, petugas dapat mengubah status pesanan menjadi `Selesai`.
- Pesanan yang sudah `Selesai` masih mempertahankan meja sebagai `Terisi` sampai petugas memilih `Kosongkan Meja`.
- Pesanan yang dibatalkan atau dihapus akan melepaskan meja dan mengembalikan stok sesuai kondisi transaksi.
- Dashboard mengambil angka langsung dari database.

## Struktur tambahan JS12

```text
sql/
└── 03_integrasi_transaksi.sql
```

## Database

Tidak membuat database baru. Tetap gunakan database **Cafe_Najwa** yang sama seperti Jobsheet 11.

Jalankan:

```bash
psql -d Cafe_Najwa -f sql/03_integrasi_transaksi.sql
```

Jika memakai Supabase/DBeaver, jalankan isi file SQL tersebut pada database Cafe_Najwa.

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
4. Pastikan pembayaran menjadi `Lunas`, tetapi status pesanan masih `Proses`.
5. Setelah makanan datang, edit pesanan dan ubah status menjadi `Selesai`.
6. Gunakan aksi `Kosongkan Meja` setelah pelanggan selesai makan.

### 4. Uji penghapusan pesanan

1. Catat stok menu.
2. Hapus pesanan aktif yang memiliki detail menu.
3. Buka Menu.
4. Stok harus kembali seperti sebelum pesanan dibuat.

### 5. Uji rollback

Jika salah satu detail pesanan gagal diproses, seluruh transaksi harus dibatalkan sehingga tidak ada pesanan/detail/stok yang tertinggal setengah jalan.

## Catatan

JS12 berfokus pada integrasi transaksi, konsistensi stok, pembayaran, penguncian meja, dan transaction database.
