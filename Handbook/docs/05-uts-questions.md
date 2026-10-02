# 05 — Pola Jawaban UTS

## Pola jawaban 4 langkah

1. **Sebut fungsi.**
2. **Sebut alasan.**
3. **Hubungkan dengan file/kode.**
4. **Sebut dampak jika dihapus/diubah.**

Contoh:

> `session_regenerate_id(true)` digunakan untuk mengganti session ID setelah login.
> Ini membantu mencegah session fixation. Pada source, fungsi dipanggil setelah
> username/password berhasil diverifikasi dan sebelum identitas user dimasukkan
> ke session. Jika dihilangkan, perlindungan terhadap session fixation berkurang.

## Pertanyaan yang harus dikuasai

- Apa fungsi PDO?
- Apa beda prepare dan execute?
- Apa fungsi fetch/fetchAll/fetchColumn?
- Kenapa ILIKE?
- Kenapa search menggunakan GET?
- Kenapa delete menggunakan POST?
- Apa rumus offset?
- Apa fungsi COUNT?
- Apa itu PK/FK?
- Mengapa detail_pesanan terpisah?
- Apa fungsi password_hash?
- Apa fungsi password_verify?
- Kenapa session_regenerate_id?
- Apa itu CSRF?
- Mengapa token disimpan di session?
- Apa fungsi hash_equals?
- Apa itu XSS?
- Apa itu SQL Injection?
- Mengapa htmlspecialchars dipakai saat output?
- Apa itu transaction?
- Mengapa perlu rollback?
- Mengapa memakai FOR UPDATE?
- Mengapa stok dikembalikan saat delete?
- Mengapa pembayaran Lunas tidak mengubah pesanan menjadi Selesai?
- Mengapa meja baru kosong setelah aksi khusus?
- Apa fungsi foreign key?
- Apa fungsi CHECK?
- Apa fungsi UNIQUE?
- Bagaimana environment variable bekerja?
