# JS06 — Fetch, Async/Await, Try/Catch/Finally

## Fetch

```js
const res = await fetch("../data/buku.json");
```

`fetch()` meminta resource. Karena operasi jaringan bersifat asynchronous, hasilnya ditunggu dengan `await` di dalam fungsi `async`.

## JSON

```js
const daftarBuku = await res.json();
```

`res.json()` juga asynchronous. Hasilnya adalah data JavaScript.

## Error handling

```js
try {
    // proses fetch
} catch (err) {
    // tampilkan error
} finally {
    // selalu dijalankan
}
```

- `try` → kode yang berpotensi gagal.
- `catch` → menangani exception/error.
- `finally` → cleanup/final state.

## `res.ok`

```js
if (!res.ok) {
    throw new Error("Gagal mengambil data");
}
```

Penting karena `fetch()` tidak otomatis melempar error hanya karena HTTP response memiliki status seperti 404. Kita memeriksa `res.ok` sendiri.
