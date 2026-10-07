# JS06 — `anggota.js`

Strukturnya hampir sama dengan `buku.js`, tetapi field yang dirender berbeda.

```js
const res = await fetch("../data/anggota.json");
const daftarAnggota = await res.json();

daftarAnggota.forEach(function (anggota) {
    const tr = document.createElement("tr");
    tr.innerHTML =
        "<td>" + anggota.no_anggota + "</td>" +
        "<td>" + anggota.nama + "</td>" +
        "<td>" + anggota.alamat + "</td>" +
        "<td>" + anggota.no_hp + "</td>";
    tbody.appendChild(tr);
});
```

## Perbedaan utama

| Buku | Anggota |
|---|---|
| `buku.json` | `anggota.json` |
| `judul` | `no_anggota` |
| `pengarang` | `nama` |
| `tahun` | `alamat` |
| `stok` | `no_hp` |

Konsep fetch dan render sama; **data model** yang berbeda.
