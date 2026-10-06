# JS1 — Beranda / Index

## 1. Tujuan
Halaman index merupakan halaman utama yang menjadi titik awal pengguna ketika membuka SIMPUS-Mini. Salah satu fungsi utamanya adalah menyediakan navigasi ke halaman lain.

## 2. Struktur

```text
index.html
   │
   ├── Header
   ├── Navigation
   ├── Main Content
   └── Footer
```

## 3. Navigasi

```html
<nav>
    <a href="index.html">Beranda</a>
    <a href="buku/list.html">Buku</a>
    <a href="anggota/list.html">Anggota</a>
</nav>
```

### `<a>`
Membuat hyperlink.

### `href`
Menentukan tujuan link.

Contoh:

```html
<a href="anggota/list.html">Anggota</a>
```

Saat link diklik, browser menuju `anggota/list.html`.

## 4. Relative Path

Jika struktur folder:

```text
SIMPUS-Mini/
├── index.html
├── buku/
│   └── list.html
└── anggota/
    └── list.html
```

Maka dari `index.html`:

```html
<a href="anggota/list.html">Anggota</a>
```

dapat digunakan untuk menuju halaman anggota.

## 5. Kenapa Navigasi Penting?

Navigasi membuat pengguna dapat berpindah halaman tanpa harus mengetik alamat file secara manual.

```text
Beranda
   ├── Buku
   └── Anggota
```

## 6. 🧠 Kalau Lupa

Pola link:

```html
<a href="TUJUAN">TEKS</a>
```

**TEKS** = yang dilihat/diklik pengguna.

**href** = tujuan.

## 7. 🎯 UTS

1. `<a>` membuat link.
2. `href` menentukan tujuan.
3. `<nav>` mengelompokkan navigasi.
4. Relative path mengikuti struktur folder.
5. Salah path dapat menyebabkan halaman tidak ditemukan.
