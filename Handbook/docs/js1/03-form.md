# JS1 — Ringkasan dan Contekan UTS

## 1. Inti JS1

Jobsheet 1 memperkenalkan struktur dasar halaman web menggunakan HTML.

```text
HTML
│
├── Struktur dokumen
├── Elemen semantik
├── Navigasi
├── Tabel
├── Form
└── Footer
```

## 2. Cheat Sheet

| Kode | Fungsi |
|---|---|
| `<!DOCTYPE html>` | Menentukan HTML5 |
| `<html>` | Pembungkus dokumen |
| `<head>` | Informasi dokumen |
| `<body>` | Isi halaman |
| `<header>` | Kepala halaman |
| `<nav>` | Navigasi |
| `<main>` | Konten utama |
| `<section>` | Kelompok konten |
| `<table>` | Tabel |
| `<thead>` | Kepala tabel |
| `<tbody>` | Isi tabel |
| `<tr>` | Baris |
| `<th>` | Judul kolom |
| `<td>` | Isi sel |
| `<form>` | Wadah form |
| `<label>` | Label input |
| `<input>` | Input data |
| `<button>` | Tombol |
| `<a>` | Link |
| `<footer>` | Kaki halaman |

## 3. Pola Tabel

```text
<table>
 ├── <thead>
 │    └── <tr>
 │         └── <th>
 │
 └── <tbody>
      └── <tr>
           └── <td>
```

## 4. Pola Form

```text
<form>
 ├── <label>
 ├── <input>
 └── <button>
```

## 5. Pola Link

```html
<a href="halaman.html">Buka Halaman</a>
```

## 6. Pertanyaan yang Mungkin Muncul

### Apa fungsi HTML?
HTML digunakan untuk membangun struktur halaman web.

### Apa perbedaan `<th>` dan `<td>`?
`<th>` untuk judul kolom, sedangkan `<td>` untuk isi data.

### Apa fungsi `<tbody>`?
Menandai bagian isi utama tabel.

### Apa fungsi `<nav>`?
Mengelompokkan bagian navigasi.

### Apa fungsi `href`?
Menentukan tujuan hyperlink.

### Apakah Edit/Hapus pada JS1 sudah bekerja?
Belum. Pada tahap JS1 tombol tersebut masih berupa tampilan dan belum terhubung ke JavaScript atau database.

## 7. 🧠 Rumus Cepat

```text
HTML = STRUKTUR

TABLE:
table → thead/tbody → tr → th/td

FORM:
form → label/input/button

LINK:
a → href

HALAMAN:
head → body
```

## 8. Kesimpulan

Setelah memahami JS1, kemampuan utama yang harus dikuasai adalah membaca struktur HTML dan menjelaskan fungsi elemen yang digunakan. JS1 menjadi fondasi sebelum masuk ke CSS, responsive design, JavaScript, JSON, dan pengembangan sistem dinamis.
