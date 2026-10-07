# JS06 — JSON

## JSON buku

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

Tanda `[` dan `]` menunjukkan **array**. Setiap `{ ... }` adalah object.

## JSON anggota

```json
[
    {
        "no_anggota": "A001",
        "nama": "Siti Aminah",
        "alamat": "Malang",
        "no_hp": "0812xxxx"
    }
]
```

## Kenapa nama property penting?

Karena JavaScript mengaksesnya secara langsung:

```js
buku.judul
buku.pengarang
buku.tahun
buku.stok
```

atau:

```js
anggota.no_anggota
anggota.nama
anggota.alamat
anggota.no_hp
```

Kalau JSON menggunakan `judul_buku` tetapi JS membaca `buku.judul`, hasilnya tidak akan sesuai.

## JSON vs JavaScript object

JSON adalah format teks terstruktur. Setelah `response.json()`, browser menghasilkan nilai JavaScript yang dapat diproses seperti array/object.
