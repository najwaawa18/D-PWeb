# Penjelasan Kode: Halaman Daftar Buku SIMPUS-Mini

Kode HTML di atas merupakan halaman antarmuka (UI) sederhana untuk menampilkan **Daftar Buku** pada sistem informasi perpustakaan mini (SIMPUS-Mini). Struktur kodenya menggunakan standar HTML5 dengan memanfaatkan elemen semantik agar mudah dibaca, diakses, dan dipelihara.

Berikut adalah rincian penjelasan per bagian:

## 1. Bagian Kepala Dokumen (`<head>`)

```html
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Daftar Buku</title>
</head>
```

- **`<meta charset="UTF-8">`**: Menentukan pengodean karakter UTF-8 agar teks, simbol, atau karakter khusus pada halaman web dapat dirender dengan benar.
- **`<title>`**: Menentukan judul halaman yang akan tampil pada tab browser, yaitu **"SIMPUS-Mini | Daftar Buku"**.

## 2. Bagian Kepala Halaman (`<header>` & Navigasi)

```html
<header>
    <h1>SIMPUS-Mini</h1>
    <nav>
        <ul>
            <li><a href="../index.html">Beranda</a></li>
            <li><a href="list.html">Daftar Buku</a></li>
            <li><a href="tambah.html">Tambah Buku</a></li>
            <li><a href="../anggota/list.html">Daftar Anggota</a></li>
        </ul>
    </nav>
</header>
```

- **`<h1>SIMPUS-Mini</h1>`**: Judul utama aplikasi yang mewakili identitas sistem perpustakaan.
- **`<nav>` dan `<ul>`**: Digunakan untuk membuat bagian navigasi berupa daftar menu yang menghubungkan halaman-halaman dalam aplikasi:
  - `../index.html`: Kembali ke halaman Beranda.
  - `list.html`: Halaman aktif saat ini, yaitu Daftar Buku.
  - `tambah.html`: Menuju formulir untuk menambahkan buku baru.
  - `../anggota/list.html`: Menuju halaman Daftar Anggota.

## 3. Konten Utama (`<main>`) & Tabel Data Buku

Bagian ini membungkus inti dari halaman, yaitu menampilkan data buku dalam bentuk tabel.

```html
<main>
    <section>
        <h2>Daftar Buku</h2>
        <table>
            ...
        </table>
    </section>
</main>
```

- **`<main>`**: Menandai bagian utama dari halaman web.
- **`<section>`**: Mengelompokkan konten yang berkaitan dengan daftar buku.
- **`<h2>`**: Menampilkan judul bagian, yaitu **Daftar Buku**.
- **`<table>`**: Digunakan untuk menampilkan data buku secara terstruktur dalam bentuk tabel.

### A. Kepala Tabel (`<thead>`)

Bagian ini mendefinisikan kolom informasi yang tersedia untuk setiap buku:

```html
<thead>
    <tr>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Tahun</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
</thead>
```

- **`<thead>`**: Menandai bagian kepala tabel.
- **`<tr>`**: Membuat baris pada tabel.
- **`<th>`**: Menentukan judul setiap kolom.

Kolom terdiri dari:

- **Judul** → nama buku.
- **Pengarang** → nama penulis buku.
- **Tahun** → tahun terbit buku.
- **Stok** → jumlah buku yang tersedia.
- **Aksi** → tombol untuk mengelola data buku.

### B. Tubuh Tabel (`<tbody>`)

Bagian `<tbody>` berisi data-data buku yang ditampilkan pada halaman.

Contoh salah satu baris data:

```html
<tr>
    <td>Laskar Pelangi</td>
    <td>Andrea Hirata</td>
    <td>2005</td>
    <td>4</td>
    <td>
        <button type="button">Edit</button>
        <button type="button">Hapus</button>
    </td>
</tr>
```

- **`<td>`**: Digunakan untuk menampilkan isi dari setiap kolom.
- `Laskar Pelangi` → judul buku.
- `Andrea Hirata` → pengarang buku.
- `2005` → tahun terbit.
- `4` → jumlah stok buku.

Data buku yang ditampilkan berjumlah **10 buku**, yaitu:

| Judul | Pengarang | Tahun | Stok |
|---|---|---:|---:|
| Laskar Pelangi | Andrea Hirata | 2005 | 4 |
| Bumi Manusia | Pramoedya Ananta Toer | 1980 | 2 |
| Negeri 5 Menara | Ahmad Fuadi | 2009 | 0 |
| Filosofi Teras | Henry Manampiring | 2018 | 5 |
| Ronggeng Dukuh Paruk | Ahmad Tohari | 1982 | 1 |
| Hujan | Tere Liye | 2016 | 6 |
| Perahu Kertas | Dee Lestari | 2009 | 4 |
| Dilan 1990 | Pidi Baiq | 2014 | 5 |
| Ayat-Ayat Cinta | Habiburrahman El Shirazy | 2004 | 3 |
| Cantik Itu Luka | Eka Kurniawan | 2002 | 2 |

## 4. Kolom Aksi

Setiap data buku memiliki dua tombol:

```html
<button type="button">Edit</button>
<button type="button">Hapus</button>
```

- **Edit**: Digunakan untuk memicu proses pengubahan data buku.
- **Hapus**: Digunakan untuk memicu proses penghapusan data buku.
- **`type="button"`**: Menentukan bahwa tombol merupakan tombol biasa.

> Pada kode saat ini, tombol **Edit** dan **Hapus** masih berupa tampilan antarmuka dan belum memiliki fungsi JavaScript atau koneksi database.

## 5. Bagian Kaki Halaman (`<footer>`)

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
</footer>
```

- **`<footer>`**: Menandai bagian bawah dokumen web.
- **`&copy;`**: Entitas HTML untuk menampilkan simbol hak cipta (©).
- **`&mdash;`**: Entitas HTML untuk menampilkan garis em-dash panjang (—).
- Informasi teks di dalamnya menunjukkan tahun pembuatan (2026), nama sistem, serta keterangan tugas praktikum (*Jobsheet 1*).

## 6. Kesimpulan

Halaman **Daftar Buku** pada SIMPUS-Mini berfungsi untuk menampilkan data buku perpustakaan dalam bentuk tabel.

Data yang ditampilkan meliputi **judul, pengarang, tahun terbit, stok, dan aksi pengelolaan data**. Halaman juga menyediakan navigasi menuju Beranda, Tambah Buku, dan Daftar Anggota.

Data pada halaman masih bersifat **statis**, sehingga perubahan melalui tombol Edit atau Hapus belum dapat dilakukan dan belum terhubung dengan database.