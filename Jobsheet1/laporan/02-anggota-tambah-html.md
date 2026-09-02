# Penjelasan Kode: Halaman Tambah Anggota SIMPUS-Mini

Kode HTML di atas merupakan halaman antarmuka (UI) sederhana untuk menyediakan formulir **Tambah Anggota** pada sistem informasi perpustakaan mini (SIMPUS-Mini). Struktur kodenya menggunakan standar HTML5 dengan memanfaatkan elemen semantik agar mudah dibaca, diakses, dan dipelihara.

Berikut adalah rincian penjelasan per bagian:

## 1. Bagian Kepala Dokumen (`<head>`)

```html
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Tambah Anggota</title>
</head>
```

- **`<meta charset="UTF-8">`**: Menentukan pengodean karakter UTF-8 agar teks, simbol, atau karakter khusus pada halaman web dapat dirender dengan benar.
- **`<title>`**: Menentukan judul halaman yang akan tampil pada tab browser, yaitu **"SIMPUS-Mini | Tambah Anggota"**.

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

- **`<h1>SIMPUS-Mini</h1>`**: Menampilkan nama atau identitas utama aplikasi perpustakaan.
- **`<nav>`**: Menandai bagian navigasi yang berisi tautan menuju halaman lain.
- **`<ul>` dan `<li>`**: Digunakan untuk membuat daftar menu navigasi.
- **`<a href>`**: Digunakan untuk membuat tautan antarhalaman:
  - `../index.html`: Menuju halaman Beranda.
  - `../buku/list.html`: Menuju halaman Daftar Buku.
  - `list.html`: Menuju halaman Daftar Anggota.
  - `tambah.html`: Menuju halaman Tambah Anggota.

## 3. Konten Utama (`<main>`) dan Formulir

Bagian ini merupakan inti halaman yang digunakan untuk memasukkan data anggota baru.

```html
<main>
    <section>
        <h2>Tambah Anggota</h2>
        <form>
            ...
        </form>
    </section>
</main>
```

- **`<main>`**: Membungkus konten utama halaman.
- **`<section>`**: Mengelompokkan bagian formulir tambah anggota.
- **`<h2>`**: Menampilkan judul bagian, yaitu **Tambah Anggota**.
- **`<form>`**: Menjadi wadah untuk seluruh input data anggota yang akan diisi oleh pengguna.

## 4. Input Data Anggota

Formulir memiliki beberapa bagian input untuk memasukkan informasi anggota.

### A. Nama

```html
<label for="nama">Nama</label><br>
<input type="text" id="nama" name="nama" required>
```

- **`<label>`**: Memberikan keterangan bahwa input digunakan untuk memasukkan nama anggota.
- **`<input type="text">`**: Menyediakan kolom untuk memasukkan teks.
- **`id="nama"`**: Memberikan identitas unik pada elemen input.
- **`name="nama"`**: Menentukan nama data yang dikirim dari input.
- **`required`**: Membuat kolom wajib diisi sebelum formulir dapat dikirim.

### B. No. Anggota

```html
<label for="no_anggota">No. Anggota</label><br>
<input type="text" id="no_anggota" name="no_anggota" required>
```

Digunakan untuk memasukkan **nomor identitas anggota**. Kolom ini juga menggunakan `required`, sehingga wajib diisi.

### C. Alamat

```html
<label for="alamat">Alamat</label><br>
<input type="text" id="alamat" name="alamat">
```

Digunakan untuk memasukkan **alamat anggota**. Berbeda dengan Nama dan No. Anggota, kolom ini tidak menggunakan `required`, sehingga boleh dikosongkan.

### D. No. HP

```html
<label for="no_hp">No. HP</label><br>
<input type="text" id="no_hp" name="no_hp">
```

Digunakan untuk memasukkan **nomor telepon anggota** dan bersifat opsional karena tidak menggunakan `required`.

## 5. Tombol Simpan

```html
<button type="submit">Simpan</button>
```

Tombol **Simpan** digunakan untuk mengirim data yang telah dimasukkan ke dalam formulir.

Atribut **`type="submit"`** menunjukkan bahwa tombol tersebut berfungsi untuk melakukan pengiriman (*submit*) form.

> Pada kode saat ini, form belum memiliki `action` dan `method`, sehingga data belum dikirim ke halaman atau server tertentu dan belum tersimpan ke database.

## 6. Bagian Kaki Halaman (`<footer>`)

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
</footer>
```

- **`<footer>`**: Menandai bagian bawah dokumen web.
- **`&copy;`**: Entitas HTML untuk menampilkan simbol hak cipta (©).
- **`&mdash;`**: Entitas HTML untuk menampilkan garis em-dash panjang (—).
- Informasi teks di dalamnya menunjukkan tahun, nama sistem, serta keterangan tugas praktikum (*Jobsheet 1*).

## 7. Kesimpulan

Halaman **Tambah Anggota** pada SIMPUS-Mini berfungsi sebagai formulir untuk memasukkan data anggota baru.

Data yang dapat dimasukkan meliputi:

- **Nama**
- **No. Anggota**
- **Alamat**
- **No. HP**

Kolom **Nama** dan **No. Anggota** wajib diisi karena menggunakan atribut `required`, sedangkan **Alamat** dan **No. HP** bersifat opsional.

Saat ini formulir masih berupa **antarmuka HTML statis**, sehingga tombol **Simpan** belum menyimpan data ke database.