# JS1 — Beranda / Index

## 1. Pengertian

Beranda atau `index` merupakan halaman utama dari sistem SIMPUS-Mini.

Halaman ini menjadi titik awal ketika pengguna membuka website.

Berbeda dengan halaman Daftar Data, Beranda tidak berfokus pada menampilkan seluruh data buku atau anggota. Beranda lebih berfungsi sebagai **halaman awal, pengenalan sistem, dan pusat navigasi**.

Sederhananya:

```text
Pengguna membuka website
          ↓
        INDEX
          ↓
     memilih menu
          ↓
menuju halaman lain
```

---

## 2. Fungsi Beranda

Beranda mempunyai beberapa fungsi utama, yaitu:

- menjadi halaman awal sistem;
- memberikan informasi awal mengenai sistem;
- menyediakan navigasi;
- mengarahkan pengguna ke halaman lain;
- menjadi pusat perpindahan antarhalaman.

Jadi, ketika pengguna membuka sistem, pengguna tidak langsung diarahkan ke tabel buku atau tabel anggota.

Pengguna terlebih dahulu berada di halaman utama.

---

## 3. Struktur Beranda

Secara umum struktur halaman Beranda dapat digambarkan seperti berikut:

```text
Beranda / Index
│
├── Header
│
├── Navigation
│   ├── Beranda
│   ├── Buku
│   └── Anggota
│
├── Main
│   └── Informasi utama sistem
│
└── Footer
```

Setiap bagian mempunyai fungsi yang berbeda.

---

## 4. Header pada Beranda

Header merupakan bagian atas halaman.

Bagian ini dapat digunakan untuk menampilkan identitas atau nama sistem.

Contohnya:

```html
<header>
    <h1>SIMPUS-Mini</h1>
</header>
```

Pada kode tersebut:

```text
<header>
    ↓
bagian kepala halaman

<h1>
    ↓
judul utama
```

Header membantu pengguna mengenali halaman atau sistem yang sedang dibuka.

---

## 5. Navigation

Bagian penting dari Beranda adalah navigasi.

Contohnya:

```html
<nav>
    <a href="index.html">Beranda</a>
    <a href="buku/list.html">Buku</a>
    <a href="anggota/list.html">Anggota</a>
</nav>
```

Navigasi berisi link yang memungkinkan pengguna berpindah ke halaman lain.

---

## 6. Fungsi `<nav>`

```html
<nav>
    ...
</nav>
```

Elemen `<nav>` digunakan untuk membungkus bagian navigasi.

Di dalamnya dapat terdapat beberapa link.

Contohnya:

```html
<nav>

    <a href="index.html">
        Beranda
    </a>

    <a href="buku/list.html">
        Buku
    </a>

    <a href="anggota/list.html">
        Anggota
    </a>

</nav>
```

Jika dibaca:

```text
NAV
│
├── Beranda
├── Buku
└── Anggota
```

---

## 7. Fungsi `<a>`

Elemen:

```html
<a href="...">
```

digunakan untuk membuat hyperlink atau link.

Contoh:

```html
<a href="buku/list.html">
    Buku
</a>
```

Teks yang terlihat pengguna adalah:

```text
Buku
```

Sedangkan tujuan link terdapat pada:

```html
href="buku/list.html"
```

---

## 8. Fungsi `href`

`href` menentukan alamat atau tujuan dari sebuah link.

Contoh:

```html
<a href="buku/list.html">
    Buku
</a>
```

Cara membacanya:

```text
Pengguna klik "Buku"
          ↓
browser membaca href
          ↓
buku/list.html
          ↓
halaman daftar buku dibuka
```

Jadi:

```text
<a>
 ↓
membuat link

href
 ↓
menentukan tujuan
```

---

## 9. Relative Path

Pada project yang mempunyai beberapa folder, alamat pada `href` perlu disesuaikan dengan posisi file.

Contoh struktur folder:

```text
SIMPUS-Mini/
│
├── index.html
│
├── buku/
│   ├── list.html
│   └── tambah.html
│
└── anggota/
    ├── list.html
    └── tambah.html
```

Karena `index.html` berada di folder utama, maka untuk menuju daftar buku dapat menggunakan:

```html
<a href="buku/list.html">
    Buku
</a>
```

Untuk menuju daftar anggota:

```html
<a href="anggota/list.html">
    Anggota
</a>
```

---

## 10. Mengapa Relative Path Penting?

Alamat file harus sesuai dengan struktur folder.

Jika struktur:

```text
index.html
buku/
    list.html
```

Maka dari `index.html` menuju `list.html`:

```text
buku/list.html
```

Bukan:

```text
list.html
```

karena `list.html` tidak berada langsung di folder yang sama dengan `index.html`.

---

## 11. Alur Navigasi Beranda

Beranda dapat menjadi pusat navigasi.

Contohnya:

```text
                    INDEX
                      │
             ┌────────┴────────┐
             ↓                 ↓
           BUKU             ANGGOTA
             ↓                 ↓
       DAFTAR BUKU       DAFTAR ANGGOTA
             │                 │
             ↓                 ↓
       TAMBAH BUKU        TAMBAH ANGGOTA
```

Dari diagram tersebut dapat dilihat bahwa Beranda tidak bertugas menampilkan seluruh data.

Beranda bertugas **menghubungkan pengguna dengan halaman lain**.

---

## 12. Beranda dan Daftar Data

Bagian ini penting karena keduanya sering terlihat mirip.

### Beranda

Beranda berfokus pada:

```text
HALAMAN UTAMA
      ↓
INFORMASI AWAL
      ↓
NAVIGASI
      ↓
PINDAH KE HALAMAN LAIN
```

### Daftar Data

Daftar Data berfokus pada:

```text
HALAMAN DATA
      ↓
TABEL
      ↓
MENAMPILKAN DATA
```

Jadi keduanya mempunyai fungsi yang berbeda.

---

## 13. Perbandingan

| Bagian | Beranda / Index | Daftar Data |
|---|---|---|
| Fungsi | Halaman utama | Menampilkan data |
| Fokus | Navigasi | Data |
| Elemen penting | `<nav>` dan `<a>` | `<table>` |
| Isi | Informasi awal dan menu | Data buku/anggota |
| Tujuan | Mengarahkan pengguna | Melihat data |

Cara cepat mengingat:

```text
INDEX
= START / AWAL

LIST
= DATA / ISI
```

---

## 14. Hubungan Index dengan Halaman Lain

Index menjadi titik awal untuk mengakses halaman lain.

Misalnya:

```text
index.html
   │
   ├── buku/list.html
   │
   ├── buku/tambah.html
   │
   ├── anggota/list.html
   │
   └── anggota/tambah.html
```

Artinya, halaman utama menyediakan jalur menuju halaman lain.

---

## 15. Cara Membaca Kode Navigasi

Misalnya menemukan:

```html
<nav>
    <a href="index.html">Beranda</a>
    <a href="buku/list.html">Buku</a>
    <a href="anggota/list.html">Anggota</a>
</nav>
```

Bacanya:

### 15.1 `<nav>`

```html
<nav>
```

Berarti mulai bagian navigasi.

### 15.2 Link Beranda

```html
<a href="index.html">Beranda</a>
```

Artinya ada link bernama **Beranda** yang menuju `index.html`.

### 15.3 Link Buku

```html
<a href="buku/list.html">Buku</a>
```

Artinya ada link bernama **Buku** yang menuju halaman daftar buku.

### 15.4 Link Anggota

```html
<a href="anggota/list.html">Anggota</a>
```

Artinya ada link bernama **Anggota** yang menuju halaman daftar anggota.

---

## 16. Kesalahan yang Mungkin Terjadi

### 16.1 Salah Menulis `href`

Contohnya:

```html
<a href="buku.html">
    Buku
</a>
```

Padahal file sebenarnya:

```text
buku/list.html
```

Maka link tidak akan menuju file yang benar.

Solusinya adalah menyesuaikan `href` dengan struktur folder.

---

### 16.2 Salah Menentukan Folder

Misalnya:

```text
index.html
buku/
    list.html
```

Maka:

```html
<a href="buku/list.html">
```

merupakan alamat yang sesuai.

Jika menulis:

```html
<a href="list.html">
```

browser akan mencari `list.html` di lokasi yang salah.

---

### 16.3 Link Tidak Mengarah ke Halaman yang Diharapkan

Jika link tidak bekerja, periksa:

1. nama file;
2. nama folder;
3. penulisan `href`;
4. posisi file terhadap `index.html`.

---

## 17. 🧠 Kalau Lupa

Ingat tiga hal:

```text
INDEX
   ↓
HALAMAN UTAMA

NAV
   ↓
NAVIGASI

A + HREF
   ↓
LINK + TUJUAN
```

Atau gunakan pola:

```text
INDEX
 ↓
NAV
 ↓
A
 ↓
HREF
 ↓
HALAMAN TUJUAN
```

---

## 18. Ringkasan

Beranda atau `index` merupakan halaman utama SIMPUS-Mini.

Halaman ini berfungsi sebagai titik awal pengguna dan menyediakan navigasi menuju halaman lain.

Elemen penting yang perlu diingat:

```text
<header>
    ↓
bagian kepala

<nav>
    ↓
navigasi

<a>
    ↓
link

href
    ↓
tujuan link
```

Sedangkan halaman Daftar Data mempunyai fokus yang berbeda:

```text
INDEX
 ↓
HALAMAN UTAMA + NAVIGASI
```

dan:

```text
LIST
 ↓
HALAMAN DATA + TABEL
```

---

## 19. 🎯 Poin yang Harus Diingat untuk UTS

### Apa fungsi `index`?

> `index` digunakan sebagai halaman utama atau titik awal pengguna ketika membuka sistem.

### Apa fungsi `<nav>`?

> `<nav>` digunakan untuk membungkus bagian navigasi pada halaman.

### Apa fungsi `<a>`?

> `<a>` digunakan untuk membuat hyperlink atau link.

### Apa fungsi `href`?

> `href` digunakan untuk menentukan tujuan dari sebuah link.

### Apa itu relative path?

> Relative path adalah penulisan alamat file berdasarkan posisi file terhadap file yang sedang dibuka.

### Apa perbedaan Beranda dan Daftar Data?

> Beranda berfungsi sebagai halaman utama dan pusat navigasi, sedangkan Daftar Data berfungsi untuk menampilkan data tertentu.

---

## 20. Kesimpulan

Inti dari bagian Beranda / Index adalah memahami bahwa `index` berfungsi sebagai **pintu masuk sistem**.

Pengguna masuk melalui:

```text
INDEX
  ↓
NAVIGASI
  ↓
PILIH MENU
  ↓
HALAMAN TUJUAN
```

Karena itu, ketika lupa cara kerja halaman Beranda, ingat:

> **Index = halaman utama.**

> **Nav = tempat navigasi.**

> **A = link.**

> **Href = tujuan link.**