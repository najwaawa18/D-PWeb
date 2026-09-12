## Tambahan Bootstrap

Pada versi ini, halaman SIMPUS-Mini telah menggunakan **Bootstrap 5.3.3** untuk membantu membuat tampilan lebih rapi dan responsif.

Bootstrap ditambahkan melalui CDN pada bagian `<head>`:

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
```

Beberapa class Bootstrap yang digunakan antara lain:

- `container` digunakan untuk mengatur lebar dan posisi konten agar lebih rapi.
- `navbar`, `navbar-expand-lg`, dan `navbar-dark` digunakan untuk membuat serta mengatur tampilan navbar.
- `navbar-toggler` dan `collapse` digunakan agar menu navigasi dapat dibuka dan ditutup pada layar kecil.
- `card` dan `card-body` digunakan untuk membuat tampilan konten dalam bentuk card.
- `shadow-sm` memberikan efek bayangan pada card.
- `row` dan `col-md-4` digunakan untuk mengatur layout ringkasan menjadi tiga kolom pada layar yang lebih besar.
- `col-12` membuat setiap bagian dapat memenuhi lebar layar pada perangkat kecil.
- `text-center` digunakan untuk membuat teks berada di tengah.
- `fw-bold` dan `fs-2` digunakan untuk mengatur ketebalan dan ukuran teks.
- `p-3`, `mb-3`, `mb-4`, dan `py-3` digunakan untuk mengatur jarak atau spacing antar elemen.
- `rounded-3` digunakan untuk membuat sudut elemen menjadi lebih membulat.

Bootstrap juga menggunakan JavaScript yang ditambahkan sebelum tag `</body>`:

```html
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

Script tersebut diperlukan untuk menjalankan komponen Bootstrap yang membutuhkan JavaScript, seperti fitur **navbar collapse/toggle** pada tampilan layar kecil.

Dengan adanya Bootstrap, halaman SIMPUS-Mini menjadi lebih **responsif, terstruktur, dan mudah disesuaikan dengan berbagai ukuran layar**.