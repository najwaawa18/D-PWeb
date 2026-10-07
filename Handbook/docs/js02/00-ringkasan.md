# Jobsheet 02 — CSS Dasar

## Tujuan

JS02 mengambil HTML dari JS01 lalu memberi desain visual menggunakan satu stylesheet bersama: `assets/style.css`.

## Perubahan paling penting

Setiap halaman sekarang memiliki:

```html
<link rel="stylesheet" href="assets/style.css">
```

Untuk halaman dalam subfolder seperti `anggota/list.html`, path menjadi:

```html
<link rel="stylesheet" href="../assets/style.css">
```

Perbedaan `assets/...` dan `../assets/...` terjadi karena **lokasi file HTML berbeda**.

## Materi inti

- CSS variables melalui `:root`.
- Universal selector `*`.
- Styling body, header, main, section, table, form, footer.
- Flexbox untuk header/navbar.
- Grid untuk kartu statistik.
- Pseudo-class `:hover` dan `:focus`.
- Border, padding, margin, background, shadow, radius.
- Media query dasar.

## Prinsip penting

HTML tetap bertanggung jawab atas struktur. CSS bertanggung jawab atas presentasi/tampilan.
