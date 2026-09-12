## Tambahan CSS: Override Bootstrap

CSS berikut digunakan sebagai **override kecil di atas Bootstrap** untuk menjaga warna dan tampilan komponen agar tetap konsisten dengan identitas visual SIMPUS-Mini.

```css
/* Override kecil di atas Bootstrap agar tetap konsisten dengan warna brand SIMPUS-Mini */

.navbar-brand,
.nav-link {
    color: #fff !important;
}

.nav-link:hover,
.nav-link.active {
    color: #d9e8f5 !important;
}

form button[type="submit"]:hover,
button[type="submit"]:hover {
    background-color: #164869 !important;
}
```

- `.navbar-brand` dan `.nav-link` digunakan untuk mengatur warna teks pada nama brand dan menu navigasi menjadi putih (`#fff`).
- `.nav-link:hover` mengatur perubahan warna menu ketika kursor diarahkan ke menu.
- `.nav-link.active` memberikan warna yang berbeda pada menu yang sedang aktif.
- `form button[type="submit"]:hover` dan `button[type="submit"]:hover` mengatur perubahan warna tombol **Simpan** ketika kursor diarahkan ke tombol.
- `!important` digunakan agar aturan CSS dari project memiliki prioritas lebih tinggi dan dapat meng-override aturan Bootstrap yang memiliki konflik.
- Warna `#1d5b8a`, `#d9e8f5`, dan `#164869` digunakan untuk mempertahankan konsistensi warna dengan brand SIMPUS-Mini.

CSS ini tidak menggantikan Bootstrap, tetapi berfungsi sebagai **penyesuaian tambahan** agar komponen Bootstrap tetap mengikuti desain yang diinginkan pada SIMPUS-Mini.