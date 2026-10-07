# JS04 — User Flow

## Apa itu user flow?

User flow adalah urutan langkah yang dilalui pengguna untuk menyelesaikan tujuan tertentu.

Contoh login petugas:

```text
[Login]
   ↓
[Username + Password]
   ↓
[Masuk]
   ↓
[Validasi]
   ├── gagal → [Pesan Error]
   └── berhasil → [Dashboard]
```

Contoh peminjaman:

```text
[Dashboard]
   ↓
[Peminjaman Baru]
   ↓
[Pilih Anggota]
   ↓
[Pilih Buku Tersedia]
   ↓
[Isi Data]
   ↓
[Simpan]
   ↓
[Transaksi Berhasil]
```

## Kenapa user flow penting?

Sebelum coding, kita bisa menemukan langkah yang hilang. Misalnya: apa yang terjadi ketika login gagal? Apa yang terjadi jika stok buku 0? Ke mana pengguna kembali setelah transaksi selesai?

User flow membuat kebutuhan tersebut terlihat sebelum UI dibuat.
