# JS01 — Form Tambah Data

## Contoh

```html
<form>
    <p>
        <label for="nama">Nama</label><br>
        <input type="text" id="nama" name="nama" required>
    </p>
    <p>
        <label for="no_anggota">No. Anggota</label><br>
        <input type="text" id="no_anggota" name="no_anggota" required>
    </p>
    <p>
        <label for="alamat">Alamat</label><br>
        <input type="text" id="alamat" name="alamat">
    </p>
    <button type="submit">Simpan</button>
</form>
```

## Bedah atribut

- `label for="nama"` harus merujuk ke `id="nama"`.
- `type="text"` berarti input teks.
- `name="nama"` adalah nama field ketika data form diproses.
- `required` membuat field wajib diisi oleh validasi bawaan browser.
- `type="submit"` membuat tombol mengirim form.

Pada JS01 form belum memiliki `action` dan `method`, sehingga belum benar-benar menyimpan data ke backend/database. Ini penting: **tampilan form ≠ sistem penyimpanan data.**

## Form buku

Form buku memakai field seperti `judul`, `pengarang`, `tahun`, dan `stok`. `tahun` dan `stok` menggunakan `type="number"`.

## Pertanyaan cepat

**Q: Apakah `id` sama dengan `name`?**

Tidak. `id` terutama digunakan untuk identitas elemen dan hubungan dengan `label`/CSS/JavaScript. `name` merupakan nama field form yang dapat digunakan saat data form diproses.
