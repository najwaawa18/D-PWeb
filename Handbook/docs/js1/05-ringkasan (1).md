# Jobsheet 01 — Konsep HTML Dasar

## 1. Gambaran Umum

Jobsheet 01 membangun **SIMPUS-Mini** sebagai antarmuka perpustakaan sederhana menggunakan HTML. Struktur halaman menggunakan elemen HTML5 seperti `head`, `header`, `nav`, `main`, `section`, dan `footer`.

## 2. Halaman yang Dibuat

- Beranda (`index.html`)
- Daftar Anggota (`anggota/list.html`)
- Tambah Anggota (`anggota/tambah.html`)
- Daftar Buku (`buku/list.html`)
- Tambah Buku (`buku/tambah.html`)

## 3. Pola Struktur

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini</title>
</head>
<body>
    <header>...</header>
    <main>...</main>
    <footer>...</footer>
</body>
</html>
```

## 4. Inti yang Perlu Diingat

- `head` berisi metadata dan `title`.
- `header` berisi identitas dan navigasi.
- `main` berisi isi utama halaman.
- `footer` berisi informasi bagian bawah halaman.
- `a href` dipakai untuk berpindah halaman.
- `table` dipakai untuk menampilkan data buku/anggota.
- `form`, `label`, dan `input` dipakai untuk halaman tambah data.
