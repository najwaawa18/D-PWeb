# JS06 — Troubleshooting

## 1. JSON tidak muncul

Cek path:

```js
fetch("../data/buku.json")
```

Karena `buku.js` berada di `assets/js/`, `../data/` naik dari `js` ke `assets`, lalu mencari `data` di root Jobsheet.

Struktur harus:

```text
Jobsheet6/
├── data/buku.json
└── assets/js/buku.js
```

## 2. Muncul `Failed to fetch`

Jangan selalu menjalankan file HTML dengan `file://`. Fetch resource lokal dapat bermasalah karena kebijakan browser. Gunakan server lokal, misalnya Laragon/Live Server sesuai lingkungan praktikum.

## 3. Data ada tetapi kolom kosong

Bandingkan nama property JSON dan JS:

```text
JSON: "pengarang"
JS:   buku.pengarang
```

Harus sama.

## 4. Tombol hapus tidak bekerja

Pastikan JS06 menggunakan event delegation, karena tombol dibuat setelah fetch.

## 5. Loading tidak hilang

Pastikan kode:

```js
finally {
    loading.style.display = "none";
}
```

tetap ada sehingga loading disembunyikan baik fetch sukses maupun gagal.
