# JS1 — Konsep HTML Dasar

## 1. Tujuan
Jobsheet 1 menjadi dasar untuk memahami struktur halaman web menggunakan HTML. Fokusnya adalah struktur dokumen, elemen semantik, navigasi, tabel, form, dan footer.

Pada tahap ini halaman masih berupa **antarmuka statis**. Tombol seperti Edit dan Hapus belum menjalankan proses JavaScript maupun database.

## 2. Struktur Dasar HTML

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPUS-Mini</title>
</head>

<body>
    <!-- isi halaman -->
</body>
</html>
```

### Penjelasan

**`<!DOCTYPE html>`**  
Memberi tahu browser bahwa dokumen menggunakan HTML5.

**`<html lang="id">`**  
Pembungkus seluruh dokumen HTML. `lang="id"` menunjukkan bahasa Indonesia.

**`<head>`**  
Berisi informasi dokumen seperti encoding, viewport, dan judul.

**`<body>`**  
Berisi seluruh bagian halaman yang dilihat pengguna.

## 3. Elemen Semantik

```html
<header>
    ...
</header>

<nav>
    ...
</nav>

<main>
    ...
</main>

<section>
    ...
</section>

<footer>
    ...
</footer>
```

Cara mengingat:

```text
HEADER  → kepala halaman
NAV     → navigasi
MAIN    → isi utama
SECTION → kelompok isi
FOOTER  → bagian bawah
```

## 4. Alur Struktur

```text
HTML
│
├── HEAD
│   ├── charset
│   ├── viewport
│   └── title
│
└── BODY
    ├── HEADER
    ├── NAV
    ├── MAIN
    │   └── SECTION
    └── FOOTER
```

## 5. 🧠 Kalau Lupa

Ingat pola:

**DOCTYPE → html → head → body**

Lalu di `body`:

**header → nav → main → section → footer**

## 6. 🎯 Yang Perlu Diingat untuk UTS

1. HTML digunakan untuk menyusun struktur halaman.
2. CSS digunakan untuk mengatur tampilan.
3. JavaScript digunakan untuk memberikan interaksi.
4. `<head>` berbeda dengan `<header>`.
5. `<head>` berisi informasi dokumen, sedangkan `<header>` merupakan bagian halaman.
