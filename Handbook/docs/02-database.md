# 02 — Database

## Tabel

`kategori`, `menu`, `pelanggan`, `meja`, `pesanan`, `detail_pesanan`, `pembayaran`, `users`.

## Relasi

- kategori 1:N menu
- pelanggan 1:N pesanan
- meja 1:N pesanan
- pesanan 1:N detail_pesanan
- menu 1:N detail_pesanan
- pesanan 1:0..1 pembayaran

## Aturan penting

- `menu.kategori_id` FK → `kategori.id`
- `pesanan.pelanggan_id` FK → `pelanggan.id`
- `pesanan.meja_id` FK → `meja.id`
- `detail_pesanan.pesanan_id` FK → `pesanan.id`
- `detail_pesanan.menu_id` FK → `menu.id`
- `pembayaran.pesanan_id` FK → `pesanan.id` + UNIQUE

## Status

Meja: `Kosong`, `Terisi`, `Dipesan`.

Pesanan: source JS12 memvalidasi `Proses`, `Selesai`, `Dibatalkan`.

Pembayaran: `Lunas`, `Belum Lunas`.

Metode: `Cash`, `QRIS`, `Debit`, `E-Wallet`.
