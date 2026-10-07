# JS06 — `app.js` dan Event Delegation

## Kenapa `app.js` berubah?

Pada JS05, tombol `.btn-hapus` dicari saat DOM selesai dimuat. Pada JS06, tombol hapus dibuat **setelah fetch**.

Jadi kode seperti ini tidak cukup jika dijalankan terlalu awal:

```js
document.querySelectorAll(".btn-hapus").forEach(...)
```

Pada saat `DOMContentLoaded`, tombol tersebut belum tentu ada.

## Solusi: event delegation

JS06 memakai:

```js
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;

    const row = btn.closest("tr");
    ...
});
```

Event click ditangkap di `document`. Ketika click terjadi, `closest(".btn-hapus")` mengecek apakah target atau ancestor-nya adalah tombol hapus.

## Kenapa teknik ini cocok?

Karena `document` sudah ada sejak awal, sedangkan tombol tabel boleh dibuat kapan saja setelah data berhasil di-fetch.

### Pola hafalan

```text
Elemen dinamis
     ↓
listener langsung terlalu awal
     ↓
gunakan parent/document
     ↓
cek target dengan closest()
```
