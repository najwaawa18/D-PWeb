# Jobsheet 06 — JSON

Data dipisahkan menjadi:

- `data/buku.json`
- `data/anggota.json`

Contoh struktur:

```json
[
    {
        "judul": "Laskar Pelangi",
        "pengarang": "Andrea Hirata",
        "tahun": 2005,
        "stok": 4
    }
]
```

Alur datanya:

**JSON → `fetch()` → `res.json()` → array → `forEach()` → baris tabel → HTML**.
