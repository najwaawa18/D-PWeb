# Penjelasan Kode: Halaman Tambah Buku SIMPUS-Mini

Kode HTML di atas merupakan halaman antarmuka (UI) untuk menambahkan data buku baru pada sistem informasi perpustakaan mini (SIMPUS-Mini). Halaman ini menggunakan struktur HTML5 dengan elemen semantik seperti `<header>`, `<main>`, `<section>`, dan `<footer>`.

Berikut adalah rincian penjelasan per bagian:

## 1. Bagian Kepala Dokumen (`<head>`)

Bagian `<head>` berisi informasi dasar mengenai halaman HTML yang tidak ditampilkan langsung pada halaman.

```html
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Tambah Buku</title>
</head>
```

- `<meta charset="UTF-8">` digunakan agar karakter dan simbol yang digunakan pada halaman dapat ditampilkan dengan benar.
- `<title>` menentukan judul halaman yang akan ditampilkan pada tab browser, yaitu **SIMPUS-Mini | Tambah Buku**.

## 2. Bagian Kepala Halaman (`<header>` & Navigasi)

Bagian `<header>` digunakan sebagai kepala halaman yang berisi nama sistem dan menu navigasi.

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

- `<h1>` menampilkan nama utama sistem, yaitu **SIMPUS-Mini**.
- `<nav>` digunakan untuk menampung bagian navigasi halaman.
- `<ul>` dan `<li>` digunakan untuk membuat daftar menu.
- `<a href="...">` digunakan sebagai tautan untuk berpindah ke halaman lain.
- `../` digunakan untuk kembali satu tingkat folder, karena halaman `tambah.html` berada di dalam folder `buku`.

Menu yang tersedia yaitu:
- **Beranda** → menuju `../index.html`
- **Daftar Buku** → menuju `list.html`
- **Tambah Buku** → menuju halaman yang sedang dibuka
- **Daftar Anggota** → menuju `../anggota/list.html`

## 3. Konten Utama (`<main>`) & Form Tambah Buku

Bagian `<main>` berisi konten utama halaman, sedangkan `<section>` digunakan untuk mengelompokkan bagian form tambah buku.

```html
<main>
    <section>
        <h2>Tambah Buku</h2>
        <form>
            ...
        </form>
    </section>
</main>
```

- `<h2>` digunakan sebagai judul halaman, yaitu **Tambah Buku**.
- `<form>` digunakan sebagai wadah untuk berbagai input data buku yang akan diisi oleh pengguna.

### A. Input Judul dan Pengarang

```html
<label for="judul">Judul</label><br>
<input type="text" id="judul" name="judul" required>
```

```html
<label for="pengarang">Pengarang</label><br>
<input type="text" id="pengarang" name="pengarang" required>
```

Kedua input digunakan untuk memasukkan **judul buku** dan **nama pengarang**.

- `type="text"` digunakan untuk input berupa teks.
- `id` memberikan identitas pada elemen input.
- `name` memberikan nama data yang akan digunakan ketika form diproses.
- `required` membuat input wajib diisi sebelum form dapat dikirim.
- `<label>` memberikan keterangan untuk setiap input.
- `for` pada `<label>` dihubungkan dengan `id` pada `<input>`.

### B. Input Tahun Terbit

```html
<label for="tahun">Tahun Terbit</label><br>
<input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
```

Input ini digunakan untuk memasukkan **tahun terbit buku**.

- `type="number"` membuat input hanya menerima data berupa angka.
- `min="1900"` menentukan batas tahun paling rendah.
- `max="2026"` menentukan batas tahun paling tinggi.
- `required` membuat data tahun wajib diisi.

### C. Input ISBN

```html
<label for="isbn">ISBN</label><br>
<input type="text" id="isbn" name="isbn">
```

Input ISBN digunakan untuk memasukkan nomor ISBN buku.

Berbeda dengan judul dan pengarang, input ISBN **tidak menggunakan `required`**, sehingga pengisiannya bersifat opsional.

### D. Input Stok

```html
<label for="stok">Stok</label><br>
<input type="number" id="stok" name="stok" min="0" required>
```

Input ini digunakan untuk menentukan jumlah stok buku yang tersedia.

- `type="number"` digunakan agar data berupa angka.
- `min="0"` memastikan jumlah stok tidak boleh kurang dari 0.
- `required` membuat stok wajib diisi.

### E. Pilihan Kategori

```html
<label for="kategori">Kategori</label><br>
<select id="kategori" name="kategori">
    <option value="fiksi">Fiksi</option>
    <option value="non-fiksi">Non-Fiksi</option>
    <option value="referensi">Referensi</option>
</select>
```

Bagian ini digunakan untuk menentukan **kategori buku** menggunakan menu pilihan.

- `<select>` membuat dropdown pilihan.
- `<option>` digunakan untuk membuat pilihan yang tersedia.
- Kategori yang disediakan adalah **Fiksi, Non-Fiksi, dan Referensi**.
- `value` merupakan nilai yang mewakili setiap pilihan ketika form diproses.

## 4. Tombol Simpan

```html
<p>
    <button type="submit">Simpan</button>
</p>
```

Tombol **Simpan** digunakan untuk mengirim data yang telah diisi pada form.

- `<button>` membuat tombol.
- `type="submit"` menunjukkan bahwa tombol digunakan untuk melakukan submit terhadap form.

Namun, pada kode ini form belum memiliki atribut `action` dan `method`, sehingga tombol **Simpan belum terhubung dengan proses penyimpanan data ke database**. Saat ini form masih berfungsi sebagai tampilan dan input data pada sisi HTML.

## 5. Bagian Kaki Halaman (`<footer>`)

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
</footer>
```

Bagian `<footer>` digunakan sebagai kaki halaman dan berisi informasi identitas sistem.

- `&copy;` menghasilkan simbol hak cipta **©**.
- `&mdash;` menghasilkan tanda pisah panjang **—**.
- Teks menunjukkan bahwa halaman merupakan bagian dari **SIMPUS-Mini — Jobsheet 1**.

## Kesimpulan

Halaman **Tambah Buku** digunakan sebagai form untuk memasukkan data buku yang terdiri dari **judul, pengarang, tahun terbit, ISBN, stok, dan kategori**. HTML5 digunakan untuk mengatur struktur halaman dan menyediakan validasi sederhana melalui atribut seperti `required`, `min`, dan `max`.

Pada tahap ini, form masih bersifat **statis** dan belum terhubung dengan database. Tombol **Simpan** juga belum melakukan penyimpanan data secara nyata karena belum terdapat backend atau proses pengolahan form.