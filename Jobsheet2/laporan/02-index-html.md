# Penjelasan Kode HTML: Beranda SIMPUS-Mini

Berikut adalah penjelasan poin-poin utama dari setiap bagian kode HTML halaman **Beranda** (`index.html`):

---

## 1. Metadata Dokumen (`<head>`)
* **`<meta charset="UTF-8">`**: Menentukan pengodean karakter UTF-8 agar teks dan simbol pada web dapat ditampilkan dengan benar.
* **`<title>`**: Menentukan judul halaman pada tab browser, yaitu **SIMPUS-Mini | Beranda**.
* **`<link rel="stylesheet" href="assets/style.css">`**: Menghubungkan berkas HTML ke file CSS (`style.css`) di folder `assets/` untuk mengatur desain visual halaman.

---

## 2. Navigasi Utama (`<header>` & `<nav>`)
* **`<h1>`**: Judul utama aplikasi (*branding*) SIMPUS-Mini.
* **`<nav>` & `<ul>`**: Menu navigasi bertingkat berupa daftar tautan untuk berpindah halaman:
  * `index.html`: Kembali ke halaman Beranda.
  * `buku/list.html`: Menuju ke halaman daftar buku.
  * `buku/tambah.html`: Menuju ke halaman form tambah buku.
  * `anggota/list.html`: Menuju ke halaman daftar anggota.

---

## 3. Konten Utama (`<main>`)
Terdiri dari dua bagian `<section>`:

* **Section Pertama (Ucapan Selamat Datang)**:
  * **`<h2>`**: Menampilkan teks judul penyambut pengguna.
  * **`<p>`**: Deskripsi singkat mengenai kegunaan aplikasi.

* **Section Kedua (Ringkasan / Statistik)**:
  * **`<h2>Ringkasan</h2>`**: Judul area rekapitulasi data.
  * **Elemen `<article>`**: Dipakai untuk mengelompokkan 3 kartu statistik secara terpisah:
    1. Kartu 1: Menampilkan **Total Buku** (10).
    2. Kartu 2: Menampilkan **Total Anggota** (7).
    3. Kartu 3: Menampilkan jumlah buku **Sedang Dipinjam** (3).

---

## 4. Kaki Halaman (`<footer>`)
* **`<footer>`**: Menandai area bawah halaman.
* **`&copy;` & `&mdash;`**: Entitas khusus HTML untuk menampilkan simbol hak cipta (©) dan garis pisah panjang (—).
* Berisi teks hak cipta tahun 2026, nama aplikasi, dan keterangan *Jobsheet 1*.