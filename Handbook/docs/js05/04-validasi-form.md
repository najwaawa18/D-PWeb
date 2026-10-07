# JS05 — Validasi Form Client-Side

## Fungsi utama

```js
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;
        // pemeriksaan field...
        if (!valid) {
            e.preventDefault();
        }
    });
}
```

## Menampilkan error

```js
function tampilkanError(input, pesan) {
    hapusError(input);

    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;

    input.insertAdjacentElement("afterend", span);
}
```

JavaScript membuat `<span>` baru, memberinya class `error`, mengisi pesan, lalu menempatkannya setelah input.

## `preventDefault`

```js
if (!valid) {
    e.preventDefault();
}
```

Browser membatalkan aksi submit normal jika data dianggap tidak valid.

## Validasi angka

```js
const nilai = parseInt(tahun.value, 10);
if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
    ...
}
```

`parseInt()` mengubah string menjadi integer. `isNaN()` mengecek apakah hasilnya bukan angka yang valid.
