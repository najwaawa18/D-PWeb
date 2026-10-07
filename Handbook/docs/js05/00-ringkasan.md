# Jobsheet 05 — JavaScript untuk Interaksi

> Di bagian ini **JavaScript** mulai digunakan. Istilah JS05 tetap berarti Jobsheet 05.

## Tujuan

JS05 membuat halaman yang sebelumnya statis menjadi interaktif di browser.

## Fitur yang ditambahkan

1. Hamburger menu berbasis JavaScript.
2. Konfirmasi hapus.
3. Filter/pencarian tabel real-time.
4. Validasi form client-side.
5. Pesan error yang dibuat melalui DOM.

## Struktur

```text
Jobsheet5/
├── assets/
│   ├── css/style.css
│   └── js/app.js
├── anggota/
├── buku/
└── index.html
```

## Perubahan konsep penting

JS04/JS03 masih banyak mengandalkan CSS. Pada JS05 tombol menu menjadi:

```html
<button type="button" id="nav-toggle-btn" ...>☰</button>
```

dan dikendalikan dengan:

```js
nav.classList.toggle("nav-open");
```

## Catatan penting

Fitur hapus **belum menghapus data permanen**. `row.remove()` hanya menghilangkan baris dari DOM. Ketika halaman dimuat ulang, data statis kembali lagi.
