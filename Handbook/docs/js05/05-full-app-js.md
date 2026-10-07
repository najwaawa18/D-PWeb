# JS05 — Peta Lengkap `assets/js/app.js`

`app.js` pada JS05 terdiri dari beberapa kelompok fungsi:

```text
initNavToggle()
       ↓
menu hamburger

initHapusConfirm()
       ↓
konfirmasi + row.remove()

initTableFilter()
       ↓
filter tbody tr

initValidasiForm()
       ↓
tampilkanError()/hapusError()
       ↓
preventDefault()
```

Semua dijalankan setelah `DOMContentLoaded`.

## Pola modular

Walaupun hanya satu file, setiap fitur dibuat dalam function terpisah. Ini lebih mudah dibaca dibandingkan menaruh seluruh logika dalam satu event listener besar.

## Yang harus diingat

- `getElementById()` → mencari berdasarkan `id`.
- `querySelector()` → mengambil elemen pertama yang cocok selector.
- `querySelectorAll()` → mengambil banyak elemen.
- `addEventListener()` → memasang handler event.
- `classList.toggle()` → tambah/hapus class.
- `closest()` → mencari ancestor terdekat.
- `remove()` → menghapus node DOM.
- `preventDefault()` → membatalkan aksi default event.
- `createElement()` → membuat elemen baru.
