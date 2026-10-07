# JS05 — DOM dan Event

## DOM

DOM (Document Object Model) adalah representasi struktur HTML yang dapat dibaca dan dimanipulasi JavaScript.

Contoh:

```js
const nav = document.querySelector("header nav");
```

Kode tersebut mencari elemen `<nav>` pertama di dalam `<header>`.

## Event listener

```js
toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
});
```

Artinya: ketika `toggleBtn` diklik, fungsi dijalankan.

## `classList.toggle`

Jika class belum ada → ditambahkan.

Jika class sudah ada → dihapus.

Ini cocok untuk state buka/tutup.

## DOMContentLoaded

```js
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
```

Fungsi-fungsi dipanggil setelah struktur HTML selesai dimuat sehingga elemen yang dicari sudah tersedia.
