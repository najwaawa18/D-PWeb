# Penjelasan Kode: Halaman Daftar Anggota SIMPUS-Mini

Kode HTML di atas merupakan halaman antarmuka (UI) sederhana untuk menampilkan **Daftar Anggota** pada sistem informasi perpustakaan mini (SIMPUS-Mini). Struktur kodenya menggunakan standar HTML5 dengan memanfaatkan elemen semantik agar mudah dibaca, diakses, dan dipelihara.

Berikut adalah rincian penjelasan per bagian:

## 1. Bagian Kepala Dokumen (`<head>`)

```html
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Daftar Anggota</title>
</head>
```

- **`<meta charset="UTF-8">`**: Menentukan pengodean karakter UTF-8 agar teks, simbol, atau karakter khusus pada halaman web dapat dirender dengan benar tanpa ada simbol yang rusak (korup).
- **`<title>`**: Menentukan judul halaman yang akan tampil di tab peramban (browser), yaitu **"SIMPUS-Mini | Daftar Anggota"**.

## 2. Bagian Kepala Halaman (`<header>` & Navigasi)

```html
<header>
    <h1>SIMPUS-Mini</h1>
    <nav>
        <ul>
            <li><a href="../index.html">Beranda</a></li>
            <li><a href="../buku/list.html">Daftar Buku</a></li>
            <li><a href="list.html">Daftar Anggota</a></li>
            <li><a href="tambah.html">Tambah Anggota</a></li>
        </ul>
    </nav>
</header>
```

- **`<h1>SIMPUS-Mini`**: Judul utama aplikasi atau situs web yang mewakili identitas sistem perpustakaan.
- **`<nav>` dan `<ul>`**: Elemen navigasi berupa daftar tak berurutan (`unordered list`) yang menyediakan tautan pintasan antarhalaman di dalam aplikasi:
  - `../index.html`: Kembali ke halaman utama (beranda) dengan keluar satu tingkat direktori (`../`).
  - `../buku/list.html`: Berpindah ke halaman daftar buku.
  - `list.html`: Halaman aktif saat ini (daftar anggota).
  - `tambah.html`: Menuju formulir untuk menambahkan data anggota baru.

## 3. Konten Utama (`<main>`) & Tabel Data Anggota

Bagian ini membungkus inti dari halaman, yakni menampilkan data anggota perpustakaan dalam bentuk tabel.

```html
<main>
    <section>
        <h2>Daftar Anggota</h2>
        <table>
            ...
        </table>
    </section>
</main>
```

### A. Kepala Tabel (`<thead>`)

Bagian ini mendefinisikan kolom-kolom informasi yang tersedia untuk setiap data anggota:

```html
<thead>
    <tr>
        <th>No. Anggota</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No. HP</th>
        <th>Aksi</th>
    </tr>
</thead>
```

- Kolom terdiri dari: **No. Anggota** (kode unik), **Nama** (nama lengkap), **Alamat** (domisili), **No. HP** (kontak), dan **Aksi** (tombol interaktif untuk pengelolaan data).

### B. Tubuh Tabel (`<tbody>`)

Berisi baris-baris data (`<tr>`) dari anggota perpustakaan. Sebagai contoh, baris pertama:

```html
<tr>
    <td>A001</td>
    <td>Siti Aminah</td>
    <td>Malang</td>
    <td>0812xxxx</td>
    <td>
        <button type="button">Edit</button>
        <button type="button">Hapus</button>
    </td>
</tr>
```

- **`<td>`**: Sel data (`table data`) yang memuat informasi spesifik seperti `A001`, `Siti Aminah`, `Malang`, dan `0812xxxx`.
- **Kolom Aksi**: Dilengkapi dengan dua buah elemen tombol (`<button>`) bertipe `button`:
  - **Edit**: Digunakan untuk memicu proses pengubahan data anggota.
  - **Hapus**: Digunakan untuk memicu proses penghapusan data anggota dari sistem.

Data ini berlanjut secara konsisten untuk anggota lainnya hingga kode `A007` (Nabila Putri).

## 4. Bagian Kaki Halaman (`<footer>`)

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
</footer>
```

- **`<footer>`**: Menandai bagian bawah dokumen web.
- **`&copy;`**: Entitas HTML untuk menampilkan simbol hak cipta (©).
- **`&mdash;`**: Entitas HTML untuk menampilkan garis em-dash panjang (`—`).
- Informasi teks di dalamnya menunjukkan tahun pembuatan (2026), nama sistem, serta keterangan tugas praktikum (*Jobsheet 1*).