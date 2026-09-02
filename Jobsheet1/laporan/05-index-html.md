# Penjelasan Kode: Halaman Beranda SIMPUS-Mini

Kode HTML di atas merupakan halaman **Beranda** dari sistem informasi perpustakaan mini (SIMPUS-Mini). Halaman ini berfungsi sebagai halaman utama yang memberikan informasi singkat mengenai sistem serta menampilkan ringkasan jumlah buku, anggota, dan buku yang sedang dipinjam.

Struktur halaman menggunakan HTML5 dengan elemen semantik seperti `<header>`, `<main>`, `<section>`, `<article>`, dan `<footer>`.

Berikut adalah rincian penjelasan per bagian:

## 1. Bagian Kepala Dokumen (`<head>`)

Bagian `<head>` berisi informasi dasar mengenai halaman yang tidak ditampilkan secara langsung pada halaman web.

```html
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Beranda</title>
</head>
```

- `<meta charset="UTF-8">` digunakan agar karakter dan simbol pada halaman dapat ditampilkan dengan benar.
- `<title>` menentukan judul yang muncul pada tab browser, yaitu **SIMPUS-Mini | Beranda**.

## 2. Bagian Kepala Halaman (`<header>` & Navigasi)

Bagian `<header>` berisi nama sistem dan menu navigasi untuk berpindah antarhalaman.

```html
<header>
    <h1>SIMPUS-Mini</h1>
    <nav>
        <ul>
            <li><a href="index.html">Beranda</a></li>
            <li><a href="buku/list.html">Daftar Buku</a></li>
            <li><a href="buku/tambah.html">Tambah Buku</a></li>
            <li><a href="anggota/list.html">Daftar Anggota</a></li>
        </ul>
    </nav>
</header>
```

- `<h1>` digunakan untuk menampilkan nama utama sistem, yaitu **SIMPUS-Mini**.
- `<nav>` digunakan untuk menandai bagian navigasi.
- `<ul>` dan `<li>` digunakan untuk menyusun menu dalam bentuk daftar.
- `<a href="...">` digunakan sebagai tautan untuk berpindah ke halaman lain.

Menu navigasi terdiri dari:
- **Beranda** → `index.html`
- **Daftar Buku** → `buku/list.html`
- **Tambah Buku** → `buku/tambah.html`
- **Daftar Anggota** → `anggota/list.html`

## 3. Konten Utama (`<main>`)

Bagian `<main>` berisi seluruh informasi utama yang ditampilkan pada halaman Beranda.

```html
<main>
    <section>
        ...
    </section>

    <section>
        ...
    </section>
</main>
```

Elemen `<main>` digunakan untuk menandai konten utama halaman, sedangkan `<section>` digunakan untuk membagi konten menjadi beberapa bagian yang memiliki fungsi berbeda.

### A. Bagian Sambutan

```html
<section>
    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
</section>
```

Bagian ini memberikan judul sambutan dan penjelasan singkat mengenai fungsi SIMPUS-Mini.

- `<h2>` digunakan sebagai judul bagian.
- `<p>` digunakan untuk menampilkan deskripsi singkat aplikasi.

### B. Bagian Ringkasan

```html
<section>
    <h2>Ringkasan</h2>
    ...
</section>
```

Bagian **Ringkasan** digunakan untuk menampilkan informasi statistik sederhana mengenai kondisi perpustakaan.

Setiap informasi statistik diletakkan di dalam elemen `<article>`.

```html
<article>
    <h3>Total Buku</h3>
    <p>10</p>
</article>
```

Elemen `<article>` digunakan untuk mengelompokkan satu informasi yang berdiri sendiri. Pada halaman ini terdapat tiga informasi ringkasan:

1. **Total Buku**
   ```html
   <h3>Total Buku</h3>
   <p>10</p>
   ```
   Menampilkan jumlah buku yang tersedia, yaitu **10 buku**.

2. **Total Anggota**
   ```html
   <h3>Total Anggota</h3>
   <p>7</p>
   ```
   Menampilkan jumlah anggota perpustakaan, yaitu **7 anggota**.

3. **Sedang Dipinjam**
   ```html
   <h3>Sedang Dipinjam</h3>
   <p>3</p>
   ```
   Menampilkan jumlah buku yang sedang dipinjam, yaitu **3 buku**.

Nilai tersebut masih berupa **data statis** yang ditulis langsung di dalam HTML, sehingga belum otomatis berubah berdasarkan data pada halaman lain atau database.

## 4. Bagian Kaki Halaman (`<footer>`)

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
</footer>
```

Bagian `<footer>` digunakan sebagai kaki halaman dan berisi informasi identitas sistem.

- `&copy;` digunakan untuk menampilkan simbol hak cipta **©**.
- `&mdash;` digunakan untuk menampilkan tanda pisah panjang **—**.
- Teks menunjukkan bahwa halaman merupakan bagian dari **SIMPUS-Mini — Jobsheet 1**.

## Kesimpulan

Halaman **Beranda** berfungsi sebagai halaman utama SIMPUS-Mini yang menyediakan navigasi ke halaman buku dan anggota serta menampilkan ringkasan informasi perpustakaan.

Data ringkasan yang ditampilkan adalah **10 buku, 7 anggota, dan 3 buku sedang dipinjam**. Pada tahap ini seluruh data masih bersifat **statis**, sehingga belum terhubung dengan database atau sistem pengolahan data secara dinamis.