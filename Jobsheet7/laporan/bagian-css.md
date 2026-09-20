## Perubahan CSS pada Jobsheet 7

Pada Jobsheet 7 terdapat penambahan **Flash Message** pada CSS. Flash Message digunakan untuk memberikan informasi kepada pengguna mengenai hasil dari proses pengolahan data, misalnya ketika data berhasil ditambahkan atau ketika terjadi kesalahan pada saat validasi.

### 1. Style Dasar Flash Message

```css
.flash {
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    font-weight: 500;
    border: 1px solid var(--border-color);
}
```

Class `.flash` merupakan style dasar yang digunakan oleh setiap pesan. Properti `padding` memberikan jarak antara isi pesan dengan batas elemen, sedangkan `margin-bottom` memberikan jarak antara pesan dengan elemen di bawahnya. `font-weight` digunakan agar teks pesan lebih mudah dibaca dan `border` memberikan garis pembatas pada pesan.

### 2. Flash Message Berhasil

```css
.flash-success {
    background-color: #f0f8f0;
    color: #2e6b2e;
    border-color: #b8d8b8;
}
```

Class `.flash-success` digunakan untuk menampilkan pesan ketika proses berhasil dilakukan. Contohnya adalah pesan **"Buku berhasil ditambahkan."** atau **"Anggota berhasil ditambahkan."** Background, warna teks, dan warna border dibuat dengan nuansa hijau untuk membedakan pesan keberhasilan dari pesan kesalahan.

### 3. Flash Message Error

```css
.flash-error {
    background-color: #f8eaea;
    color: #a31c1c;
    border-color: #d9aaaa;
}
```

Class `.flash-error` digunakan untuk menampilkan pesan ketika terjadi kesalahan dalam proses pengolahan data, misalnya ketika data wajib belum diisi atau nilai yang dimasukkan tidak sesuai dengan ketentuan validasi. Warna merah digunakan agar pesan kesalahan lebih mudah dikenali oleh pengguna.

### Kesimpulan

Penambahan CSS Flash Message pada Jobsheet 7 berfungsi untuk mendukung mekanisme pemberian informasi dari proses PHP kepada pengguna. Dengan adanya perbedaan tampilan antara pesan **success** dan **error**, pengguna dapat lebih mudah mengetahui apakah data berhasil diproses atau terdapat kesalahan yang perlu diperbaiki.