# Jobsheet 06 — JSON & Fetch API

## Tujuan

JS06 mengubah tabel yang sebelumnya berisi data HTML statis menjadi tabel yang diisi **secara dinamis** dari file JSON menggunakan Fetch API.

## Struktur

```text
Jobsheet6/
├── data/
│   ├── anggota.json
│   └── buku.json
├── assets/
│   ├── css/style.css
│   └── js/
│       ├── app.js
│       ├── anggota.js
│       └── buku.js
└── halaman HTML...
```

## Alur besar

```text
HTML dibuka
   ↓
DOMContentLoaded
   ↓
anggota.js / buku.js
   ↓
fetch("../data/*.json")
   ↓
response.json()
   ↓
array object
   ↓
forEach()
   ↓
createElement("tr")
   ↓
appendChild()
   ↓
tabel tampil
```

## Perubahan penting dari JS05

Data tidak lagi ditulis satu per satu di `<tbody>`. `<tbody>` dikosongkan lalu diisi JavaScript setelah JSON berhasil dibaca.
