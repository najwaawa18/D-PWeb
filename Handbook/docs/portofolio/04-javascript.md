# Portfolio — JavaScript

`app.js` digunakan untuk interaksi portfolio seperti membuka bagian portfolio dari tombol Explore dan berpindah antar panel kategori.

Pola interaksinya:

```text
Klik tombol
   ↓
JavaScript membaca target
   ↓
Panel yang sesuai ditampilkan
   ↓
Tombol Back mengembalikan kategori
```

Karena portfolio memakai class dan `data-target`, perubahan struktur HTML harus tetap menjaga nama class/ID yang digunakan JavaScript.
