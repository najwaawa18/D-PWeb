## Perubahan CSS dari Jobsheet 5 ke Jobsheet 6

Pada Jobsheet 6, sebagian besar CSS masih menggunakan aturan dari Jobsheet 5. Perubahan utama terdapat pada **tampilan tabel di perangkat mobile**, sedangkan CSS lainnya tetap digunakan untuk mendukung fitur yang sudah dibuat sebelumnya.

### 1. Penyesuaian Tabel pada Tampilan Mobile

Pada Jobsheet 6, ditambahkan aturan khusus di dalam `@media (max-width: 480px)` untuk membuat tabel menyesuaikan lebar layar HP.

```css
/* Tabel agar seluruh kolom terlihat di layar HP */
.table-responsive {
    overflow-x: visible;
}

table {
    width: 100%;
    table-layout: fixed;
    font-size: 0.75rem;
}

th,
td {
    padding: 0.45rem 0.3rem;
    word-break: break-word;
}

td button {
    padding: 0.3rem 0.4rem;
    font-size: 0.7rem;
    margin-right: 0.1rem;
}
```

Perubahan tersebut digunakan untuk mengatur tabel agar lebih sesuai dengan ukuran layar mobile.

- `.table-responsive { overflow-x: visible; }` mengubah perilaku tabel pada JS5 yang sebelumnya menggunakan `overflow-x: auto`, sehingga tabel tidak dibuat sebagai area scroll horizontal pada layar HP.
- `table-layout: fixed` membuat lebar kolom tabel dibagi berdasarkan ruang yang tersedia.
- `font-size: 0.75rem` memperkecil ukuran teks tabel agar lebih banyak informasi dapat ditampilkan pada layar kecil.
- `padding: 0.45rem 0.3rem` memperkecil jarak dalam setiap sel tabel.
- `word-break: break-word` memungkinkan teks yang panjang dipisahkan agar tidak membuat tabel melebar keluar dari layar.
- Ukuran tombol pada tabel juga diperkecil melalui `padding` dan `font-size` agar tombol **Edit** dan **Hapus** tetap dapat ditampilkan pada layar HP.

### 2. Perubahan Perilaku `.table-responsive`

Pada JS5, CSS tabel responsif hanya menggunakan:

```css
.table-responsive {
    overflow-x: auto;
}
```

Artinya, ketika tabel terlalu lebar, pengguna dapat melakukan scroll secara horizontal.

Pada JS6, aturan tersebut tetap digunakan secara umum, tetapi **diubah khusus untuk layar maksimal 480px**:

```css
@media (max-width: 480px) {
    .table-responsive {
        overflow-x: visible;
    }
}
```

Dengan demikian, pada layar HP tabel tidak menggunakan mekanisme scroll horizontal seperti sebelumnya dan ukurannya disesuaikan melalui `table-layout`, ukuran font, padding, dan pemotongan teks.

### Kesimpulan

Perubahan CSS dari Jobsheet 5 ke Jobsheet 6 terutama berfokus pada **penyesuaian tabel untuk perangkat mobile**.

Perubahan yang ditambahkan adalah:

1. Mengubah `overflow-x` tabel pada layar HP menjadi `visible`.
2. Menggunakan `table-layout: fixed` agar lebar kolom menyesuaikan layar.
3. Memperkecil ukuran teks tabel.
4. Mengurangi padding pada `th` dan `td`.
5. Menggunakan `word-break: break-word` untuk teks yang panjang.
6. Memperkecil ukuran tombol **Edit** dan **Hapus** pada layar HP.

Perubahan tersebut membuat tabel pada halaman **Daftar Buku** dan **Daftar Anggota** lebih sesuai dengan ukuran layar perangkat mobile.