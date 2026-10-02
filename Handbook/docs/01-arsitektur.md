# 01 — Arsitektur Cafe_Najwa

## Pola request

Browser → halaman PHP → include config/helper → PDO → PostgreSQL → hasil query → PHP membuat HTML → browser.

## Pembagian folder

- `config/`: koneksi database.
- `layout/`: header, navbar, footer.
- `includes/`: auth dan security helper.
- `auth/`: register, login, logout.
- `master/`: kategori, menu, pelanggan, meja.
- `transaksi/`: pesanan dan pembayaran.
- `laporan/`: laporan penjualan, pelanggan, menu terlaris.
- `sql/`: schema dan perubahan database.

## Pola halaman CRUD

`index.php` → menampilkan data.

`form.php` → form tambah/edit.

`proses.php` → INSERT/UPDATE.

`hapus.php` → DELETE.

Pada JS11/12 operasi POST perubahan data dilindungi CSRF.
