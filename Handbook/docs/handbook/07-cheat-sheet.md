# Desain Handbook — Cheat Sheet

```text
HTML
 ├─ sidebar
 ├─ topbar
 └─ reader

CSS
 ├─ grid desktop
 ├─ off-canvas mobile
 ├─ typography
 └─ maroon design tokens

JavaScript
 ├─ menu → openDoc()
 ├─ fetch .md
 ├─ markdownToHtml()
 ├─ search menu
 └─ mobile sidebar
```

### Kunci utama

- `data-doc` = lokasi dokumen.
- `fetch()` = mengambil Markdown.
- `res.text()` = membaca isi Markdown sebagai teks.
- `markdownToHtml()` = parser sederhana.
- `reader.innerHTML` = menampilkan hasil.
- `.active` = menu yang sedang dipilih.
- `.open` = sidebar mobile terbuka.

### Desain tidak perlu diubah

Kalau hanya menambah materi, cukup:

```text
buat .md → tambah data-doc → test
```

Tidak perlu membuat layout baru.
