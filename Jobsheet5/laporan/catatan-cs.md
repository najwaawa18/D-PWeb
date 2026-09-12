## Perubahan CSS dari Jobsheet 4 ke Jobsheet 5

Pada Jobsheet 5, CSS mengalami beberapa penambahan untuk mendukung fitur interaktif yang ditambahkan menggunakan JavaScript, seperti **menu hamburger, pencarian, tabel responsif, dan pesan error validasi**.

### 1. Tabel Responsif

Ditambahkan class `.table-responsive` untuk membungkus tabel pada halaman Daftar Buku dan Daftar Anggota.

```css
.table-responsive {
    overflow-x: auto;
}
```

Properti `overflow-x: auto` membuat tabel dapat digeser secara horizontal ketika ukuran layar terlalu kecil, sehingga tabel tetap dapat digunakan pada perangkat mobile.

### 2. Tampilan Tombol Hamburger

Ditambahkan CSS untuk `.nav-toggle` dan `.nav-toggle-label` sebagai bagian dari fitur menu hamburger.

```css
.nav-toggle {
    display: none;
}

.nav-toggle-label {
    display: none;
    font-size: 1.8rem;
    color: #ffffff;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.2rem 0.5rem;
}
```

Pada tampilan normal, tombol hamburger disembunyikan. Tombol ini akan ditampilkan pada ukuran layar mobile melalui media query.

### 3. Pesan Error Validasi

Ditambahkan class `.error` untuk mengatur tampilan pesan kesalahan yang diberikan oleh JavaScript ketika validasi form tidak terpenuhi.

```css
.error {
    display: block;
    color: #a31c1c;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
```

CSS ini membuat pesan error tampil sebagai teks berwarna merah dengan ukuran yang lebih kecil dan jarak yang sesuai di bawah input.

### 4. Kolom Pencarian

Ditambahkan styling untuk `.search-box` dan input pencarian.

```css
.search-box {
    margin-bottom: 1rem;
}

.search-box input {
    width: 100%;
    max-width: 320px;
    padding: 0.5rem 0.75rem;
    border: 1px solid #cca3a3;
    border-radius: 0 !important;
    font-size: 0.95rem;
}
```

CSS ini digunakan pada kolom pencarian di halaman **Daftar Buku** dan **Daftar Anggota** agar tampilannya lebih rapi dan memiliki ukuran yang sesuai.

### 5. Responsive Navbar pada Mobile

Pada ukuran layar maksimal 480px, ditambahkan aturan untuk mengubah navbar menjadi menu hamburger.

```css
@media (max-width: 480px) {
    .nav-toggle-label {
        display: block;
    }

    header nav {
        display: none;
        width: 100%;
        order: 3;
        margin-top: 0.8rem;
    }

    header nav.nav-open {
        display: block;
    }

    header nav ul {
        flex-direction: column;
        gap: 0.2rem;
    }
}
```

Menu navigasi awalnya disembunyikan pada layar kecil. Ketika JavaScript menambahkan class `.nav-open`, menu akan ditampilkan. Menu juga diubah menjadi susunan vertikal agar lebih mudah digunakan pada perangkat mobile.

### 6. Responsive Kartu Ringkasan

CSS responsive untuk kartu statistik juga ditambahkan pada ukuran layar yang lebih kecil.

```css
@media (max-width: 768px) {
    main section:has(article) {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    main section:has(article) {
        grid-template-columns: 1fr;
    }
}
```

Pada tablet, kartu ringkasan ditampilkan menjadi **2 kolom**, sedangkan pada layar mobile menjadi **1 kolom**.

### 7. Penyesuaian Form pada Mobile

Pada layar kecil, ukuran input form dibuat mengikuti lebar layar.

```css
@media (max-width: 480px) {
    form input[type="text"],
    form input[type="number"],
    form select {
        max-width: 100%;
    }
}
```

Hal ini membuat form **Tambah Buku** dan **Tambah Anggota** lebih nyaman digunakan pada perangkat dengan layar kecil.

### Kesimpulan

Perubahan CSS pada Jobsheet 5 terutama digunakan untuk mendukung fitur baru dari JavaScript dan meningkatkan **responsivitas tampilan**. Perubahan utamanya meliputi:

- `.table-responsive` untuk tabel pada layar kecil.
- `.nav-toggle-label` dan `.nav-open` untuk menu hamburger.
- `.error` untuk pesan validasi form.
- `.search-box` untuk kolom pencarian.
- Media query untuk menyesuaikan navbar, kartu ringkasan, dan form pada perangkat mobile.

Dengan tambahan tersebut, CSS Jobsheet 5 tidak hanya mengatur tampilan, tetapi juga mendukung fitur interaktif dan responsive yang ditambahkan pada Jobsheet 5.