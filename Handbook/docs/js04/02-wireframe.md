# JS04 — Wireframe

## Contoh wireframe Login

```text
+----------------------------------+
|           SIMPUS-Mini            |
|----------------------------------|
|          LOGIN PETUGAS           |
|                                  |
| Username                         |
| [________________________]       |
|                                  |
| Password                         |
| [________________________]       |
|                                  |
|          [   MASUK   ]           |
+----------------------------------+
```

Perhatikan bahwa wireframe tidak memerlukan warna final, gradient, atau animasi. Yang dicari adalah posisi dan hubungan komponen.

## Dashboard

```text
Navbar
────────────────────────────────
DASHBOARD PETUGAS

[ TOTAL BUKU ] [ TOTAL ANGGOTA ] [ DIPINJAM ]

[ + Peminjaman Baru ] [ Pengembalian ]

Tabel transaksi terbaru
```

## Hubungan dengan HTML

Kotak pada wireframe nantinya bisa menjadi:

- judul → `<h1>`/`<h2>`;
- area navigasi → `<nav>`;
- statistik → `<article>`;
- tabel → `<table>`;
- aksi → `<button>`;
- input → `<form>` + `<input>`.

Jadi wireframe membantu menentukan **struktur HTML**, bukan sekadar menggambar tampilan.
