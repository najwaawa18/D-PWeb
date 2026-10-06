# Jobsheet 06 — `app.js`

`app.js` tetap menangani fungsi umum yang digunakan halaman, termasuk menu hamburger, pencarian, validasi form, dan fungsi hapus.

Pada Jobsheet 06, tombol Hapus yang dibuat dinamis membutuhkan pendekatan **event delegation** agar event tetap dapat bekerja pada elemen yang baru dibuat JavaScript.

Konsepnya:

```text
Klik pada container tabel
        ↓
cek apakah target adalah tombol Hapus
        ↓
jalankan fungsi hapus
```
