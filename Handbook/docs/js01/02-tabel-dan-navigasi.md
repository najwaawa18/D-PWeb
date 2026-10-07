# JS01 — Tabel dan Navigasi

## Navigasi antarhalaman

Contoh dari `anggota/list.html`:

```html
<nav>
    <ul>
        <li><a href="../index.html">Beranda</a></li>
        <li><a href="../buku/list.html">Daftar Buku</a></li>
        <li><a href="list.html">Daftar Anggota</a></li>
        <li><a href="tambah.html">Tambah Anggota</a></li>
    </ul>
</nav>
```

### Memahami `../`

`../` berarti naik satu folder dari lokasi file saat ini.

Jika file berada di:

```text
Jobsheet1/anggota/list.html
```

maka:

```text
../index.html
```

mengarah ke:

```text
Jobsheet1/index.html
```

Sedangkan `tambah.html` tanpa `../` berarti file tersebut dicari di folder `anggota` yang sama.

## Struktur tabel

```html
<table>
    <thead>
        <tr>
            <th>No. Anggota</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>A001</td>
            <td>Siti Aminah</td>
            <td>
                <button type="button">Edit</button>
                <button type="button">Hapus</button>
            </td>
        </tr>
    </tbody>
</table>
```

- `table`: wadah tabel.
- `thead`: kepala tabel.
- `tbody`: data tabel.
- `tr`: satu baris.
- `th`: cell header.
- `td`: cell data.

**Ingat:** `th` menjelaskan kolom/baris, sedangkan `td` berisi nilai data.
