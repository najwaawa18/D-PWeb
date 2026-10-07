# JS05 — Hamburger dan Konfirmasi Hapus

## Hamburger

```js
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");

    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}
```

### Kenapa ada `if (!toggleBtn || !nav) return`?

Karena `app.js` dipasang di beberapa halaman. Tidak semua halaman harus memiliki elemen yang sama. Jika elemen tidak ada, fungsi berhenti daripada menyebabkan error.

## Konfirmasi hapus

```js
const row = btn.closest("tr");
const nama = row
    ? row.querySelector("td")?.textContent
    : "data ini";

const yakin = confirm(
    'Yakin ingin menghapus "' + nama + '"?'
);

if (yakin && row) {
    row.remove();
}
```

- `closest("tr")` mencari baris tabel terdekat.
- `querySelector("td")` mengambil cell pertama.
- `confirm()` menampilkan dialog OK/Cancel.
- `row.remove()` menghapus node dari DOM.

**Belum ada database.** Jadi ini hanya perubahan tampilan browser.
