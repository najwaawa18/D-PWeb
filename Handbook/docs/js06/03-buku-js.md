# JS06 — `buku.js`

## Fungsi utama

```js
async function muatDaftarBuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        const res = await fetch("../data/buku.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarBuku = await res.json();

        daftarBuku.forEach(function (buku) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.tahun + "</td>" +
                "<td>" + buku.stok + "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan="5">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}
```

## Bedah

- `async` memungkinkan penggunaan `await`.
- `fetch()` melakukan request.
- `res.ok` mengecek status response yang dianggap berhasil.
- `res.json()` membaca body sebagai JSON.
- `forEach()` mengulang setiap object buku.
- `createElement("tr")` membuat row baru.
- `innerHTML` mengisi cell.
- `appendChild()` memasukkan row ke tabel.
- `catch` menangani error.
- `finally` dijalankan baik sukses maupun gagal.
