# JS1 — Daftar Data

## 1. Pengertian

Halaman Daftar Data digunakan untuk menampilkan kumpulan data yang sudah tersedia pada sistem SIMPUS-Mini.

Pada Jobsheet 1, halaman ini digunakan untuk menampilkan data dalam bentuk tabel sehingga pengguna dapat melihat informasi secara terstruktur.

Halaman Daftar Data berbeda dengan Beranda karena tujuan utamanya bukan sebagai halaman awal, tetapi sebagai halaman untuk **melihat isi data**.

---

## 2. Data yang Ditampilkan

Pada SIMPUS-Mini terdapat beberapa halaman daftar data, seperti:

- Daftar Buku
- Daftar Anggota

Masing-masing halaman menampilkan data sesuai kategorinya.

Contohnya:

```text
Daftar Buku
    ↓
Menampilkan data buku

Daftar Anggota
    ↓
Menampilkan data anggota
```

Dengan adanya halaman daftar, pengguna dapat melihat informasi yang sudah tersedia tanpa harus membuka atau mengubah data secara langsung.

---

## 3. Struktur Halaman Daftar Data

Secara umum halaman daftar data terdiri dari:

```text
Halaman Daftar
│
├── Header
│
├── Navigasi
│
└── Main
    │
    ├── Judul halaman
    │
    ├── Keterangan
    │
    ├── Tombol / link tambah data
    │
    └── Tabel data
```

Fokus utama halaman ini adalah **penampilan data**.

Karena itu, bagian tabel menjadi bagian penting yang harus dipahami pada halaman daftar.

---

## 4. Struktur Tabel

Data dapat ditampilkan menggunakan elemen HTML `<table>`.

Contoh struktur tabel:

```html
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Judul</th>
            <th>Penulis</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>B001</td>
            <td>Belajar HTML</td>
            <td>Najwa</td>
        </tr>

        <tr>
            <td>B002</td>
            <td>Belajar CSS</td>
            <td>Najwa</td>
        </tr>
    </tbody>
</table>
```

Kode tersebut menunjukkan struktur dasar tabel yang terdiri dari kepala tabel dan isi tabel.

---

## 5. Penjelasan Bagian Tabel

### 5.1 `<table>`

```html
<table>
    ...
</table>
```

`<table>` merupakan elemen utama yang digunakan untuk membuat tabel.

Semua bagian tabel diletakkan di dalam elemen ini.

---

### 5.2 `<thead>`

```html
<thead>
    ...
</thead>
```

`<thead>` digunakan untuk menampung bagian kepala tabel.

Biasanya bagian ini berisi nama atau judul dari setiap kolom.

Contohnya:

```html
<thead>
    <tr>
        <th>Kode</th>
        <th>Judul</th>
        <th>Penulis</th>
    </tr>
</thead>
```

---

### 5.3 `<tr>`

```html
<tr>
    ...
</tr>
```

`<tr>` digunakan untuk membuat satu baris pada tabel.

Contohnya:

```html
<tr>
    <td>B001</td>
    <td>Belajar HTML</td>
    <td>Najwa</td>
</tr>
```

Kode tersebut menghasilkan satu baris data.

---

### 5.4 `<th>`

```html
<th>Kode</th>
```

`<th>` digunakan untuk membuat judul kolom.

Contohnya:

```html
<th>Kode</th>
<th>Judul</th>
<th>Penulis</th>
```

Jika dibaca:

```text
Kode    → kolom kode
Judul   → kolom judul
Penulis → kolom penulis
```

---

### 5.5 `<tbody>`

```html
<tbody>
    ...
</tbody>
```

`<tbody>` digunakan untuk menampung isi atau data utama tabel.

---

### 5.6 `<td>`

```html
<td>B001</td>
```

`<td>` digunakan untuk menampilkan nilai atau isi dari suatu kolom.

Contohnya:

```html
<tr>
    <td>B001</td>
    <td>Belajar HTML</td>
    <td>Najwa</td>
</tr>
```

Maka:

```text
B001
    ↓
Kode

Belajar HTML
    ↓
Judul

Najwa
    ↓
Penulis
```

---

## 6. Hubungan `<th>` dan `<td>`

Judul kolom pada `<th>` harus sesuai dengan data yang terdapat pada `<td>`.

Contohnya:

```html
<tr>
    <th>Kode</th>
    <th>Judul</th>
    <th>Penulis</th>
</tr>
```

Kemudian data:

```html
<tr>
    <td>B001</td>
    <td>Belajar HTML</td>
    <td>Najwa</td>
</tr>
```

Maka hasil pembacaannya:

| Kode | Judul | Penulis |
|---|---|---|
| B001 | Belajar HTML | Najwa |

Jadi urutan data harus sesuai dengan urutan kolom.

---

## 7. Daftar Buku

Halaman Daftar Buku digunakan untuk menampilkan informasi mengenai buku yang tersedia.

Secara sederhana alurnya:

```text
Daftar Buku
    ↓
Menampilkan tabel buku
    ↓
Pengguna dapat melihat data buku
```

Data yang ditampilkan disesuaikan dengan struktur data buku pada project.

Contoh gambaran tabel:

```text
Kode | Judul | Penulis | ...
--------------------------------
B001 | ...   | ...     | ...
B002 | ...   | ...     | ...
```

Tujuan utama halaman ini adalah membuat data buku lebih mudah dibaca oleh pengguna.

---

## 8. Daftar Anggota

Halaman Daftar Anggota mempunyai konsep yang sama, tetapi data yang ditampilkan adalah data anggota.

Alurnya:

```text
Daftar Anggota
    ↓
Menampilkan tabel anggota
    ↓
Pengguna melihat data anggota
```

Jadi perbedaannya terdapat pada **jenis data yang ditampilkan**.

```text
Daftar Buku
    ↓
Data Buku

Daftar Anggota
    ↓
Data Anggota
```

---

## 9. Hubungan dengan Halaman Tambah Data

Halaman daftar tidak hanya digunakan untuk melihat data.

Biasanya halaman daftar juga menyediakan tombol atau link yang mengarah ke halaman tambah data.

Contohnya:

```html
<a href="tambah.html">
    Tambah Data
</a>
```

Alurnya:

```text
Daftar Data
     ↓
Klik "Tambah Data"
     ↓
Halaman Form
     ↓
Pengguna mengisi data
```

Dengan demikian, halaman daftar dan halaman form mempunyai fungsi yang berbeda tetapi saling berhubungan.

---

## 10. Daftar Data vs Form

### Daftar Data

Digunakan untuk:

> **Melihat data yang tersedia.**

Alurnya:

```text
Daftar
   ↓
Tabel
   ↓
Melihat Data
```

### Form

Digunakan untuk:

> **Memasukkan data.**

Alurnya:

```text
Form
   ↓
Input
   ↓
Mengisi Data
```

Jadi jangan sampai tertukar.

---

## 11. Daftar Data vs Beranda

### Beranda

Beranda merupakan halaman utama sistem.

Fokusnya:

```text
Halaman Utama
      ↓
Navigasi
      ↓
Menuju halaman lain
```

### Daftar Data

Daftar Data merupakan halaman yang menampilkan data tertentu.

Fokusnya:

```text
Halaman Data
      ↓
Tabel
      ↓
Menampilkan data
```

Perbedaannya:

| Bagian | Beranda | Daftar Data |
|---|---|---|
| Fungsi utama | Halaman awal | Menampilkan data |
| Fokus | Navigasi | Tabel |
| Isi utama | Menu / informasi | Data |
| Tujuan | Mengarahkan pengguna | Melihat data |

---

## 12. Cara Membaca Kode Tabel

Jika menemukan kode:

```html
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>001</td>
            <td>Najwa</td>
        </tr>
    </tbody>
</table>
```

Bacanya dari struktur paling luar:

```text
<table>
    ↓
    tabel

<thead>
    ↓
    kepala tabel

<tr>
    ↓
    baris

<th>
    ↓
    nama kolom
```

Kemudian:

```text
<tbody>
    ↓
    isi tabel

<tr>
    ↓
    baris data

<td>
    ↓
    isi data
```

---

## 13. Hal yang Perlu Diperhatikan

Ketika membuat halaman daftar data, beberapa hal yang perlu diperhatikan:

1. Struktur `<table>` harus benar.
2. `<thead>` digunakan untuk kepala tabel.
3. `<tbody>` digunakan untuk isi data.
4. `<tr>` digunakan untuk baris.
5. `<th>` digunakan untuk judul kolom.
6. `<td>` digunakan untuk isi kolom.
7. Urutan `<td>` harus sesuai dengan urutan `<th>`.
8. Link menuju halaman tambah harus menggunakan alamat yang benar.

---

## 14. Kesalahan yang Mungkin Terjadi

### 14.1 Data Tidak Berada di Kolom yang Sesuai

Hal ini dapat terjadi jika urutan `<td>` tidak sesuai dengan `<th>`.

Contoh:

```html
<th>Kode</th>
<th>Nama</th>

<td>Najwa</td>
<td>001</td>
```

Data menjadi tertukar.

Seharusnya:

```html
<td>001</td>
<td>Najwa</td>
```

---

### 14.2 Link Tambah Tidak Berfungsi

Misalnya:

```html
<a href="tambah.html">
```

tetapi file sebenarnya berada di folder lain.

Maka browser tidak dapat menemukan halaman tersebut.

Karena itu, alamat pada `href` harus disesuaikan dengan struktur folder.

---

## 15. 🧠 Kalau Lupa

Ingat pola berikut:

```text
DAFTAR DATA
     ↓
   TABLE
     ↓
 ┌───┴────┐
 ↓        ↓
THEAD    TBODY
 ↓        ↓
TH       TD
```

Cara paling cepat mengingat:

```text
TR = BARIS
TH = JUDUL KOLOM
TD = ISI DATA
```

---

## 16. Kesimpulan

Halaman Daftar Data berfungsi untuk **menampilkan data yang sudah tersedia** dalam bentuk yang terstruktur.

Pada SIMPUS-Mini, halaman ini dapat digunakan untuk menampilkan data buku maupun anggota.

Hal yang paling penting untuk dipahami adalah struktur tabel:

```text
<table>
    ↓
<thead> → kepala tabel
    ↓
<tbody> → isi data
    ↓
<tr>    → baris
    ↓
<th>    → judul kolom
<td>    → isi data
```

**Inti JS1 bagian Daftar Data:**

> Daftar Data = halaman untuk melihat data, dengan tabel sebagai bagian utama penyajian data.