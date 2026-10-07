# JS05 — Filter Tabel Real-Time

## Kode

```js
const input = document.getElementById("search-input");
const table = document.querySelector(".table-responsive table");

input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(function (row) {
        const teks = row.textContent.toLowerCase();
        row.style.display = teks.includes(keyword) ? "" : "none";
    });
});
```

## Alurnya

```text
User mengetik
     ↓
keyup event
     ↓
ambil keyword
     ↓
ambil semua tr
     ↓
bandingkan textContent
     ↓
match → tampil
no match → display:none
```

`toLowerCase()` dipakai agar pencarian tidak membedakan huruf besar/kecil.

`includes(keyword)` mengecek apakah teks mengandung kata yang dicari.

## Kenapa memakai `textContent`?

Karena seluruh isi teks baris dapat diperiksa tanpa harus tahu setiap kolom satu per satu. Akibatnya pencarian dapat menemukan nama, alamat, judul, pengarang, dan teks lain yang ada dalam row.
