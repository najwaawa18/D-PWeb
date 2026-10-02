# 70+ Drill Pertanyaan UTS

## 1. Apa fungsi PDO dalam project?
**Jawaban:** PDO menjadi interface PHP untuk berkomunikasi dengan database; pada project digunakan dengan driver PostgreSQL.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 2. Kenapa prepare() penting?
**Jawaban:** Query dipersiapkan dengan placeholder sehingga nilai input diberikan terpisah melalui execute().

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 3. Apa fungsi execute()?
**Jawaban:** Menjalankan prepared statement dan mengirim parameter.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 4. Apa beda fetch dan fetchAll?
**Jawaban:** fetch mengambil satu row; fetchAll mengambil banyak row.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 5. Kapan fetchColumn digunakan?
**Jawaban:** Saat membutuhkan satu nilai, misalnya hasil COUNT.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 6. Kenapa search memakai GET?
**Jawaban:** Search tidak mengubah data dan parameter keyword/page cocok direpresentasikan di URL.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 7. Kenapa tambah/edit/hapus memakai POST?
**Jawaban:** Karena operasi tersebut mengubah state/data dan endpoint POST dapat dilindungi CSRF.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 8. Kenapa ILIKE?
**Jawaban:** PostgreSQL menyediakan pencarian pattern case-insensitive.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 9. Apa fungsi LIMIT?
**Jawaban:** Membatasi jumlah row yang diambil.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 10. Apa fungsi OFFSET?
**Jawaban:** Melewati sejumlah row sebelum mengambil data halaman aktif.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 11. Rumus offset?
**Jawaban:** (page - 1) × perPage.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 12. Apa primary key?
**Jawaban:** Identitas unik satu record dalam tabel.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 13. Apa foreign key?
**Jawaban:** Kolom yang mereferensikan key tabel lain untuk menjaga hubungan data.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 14. Apa fungsi UNIQUE?
**Jawaban:** Mencegah nilai tertentu berulang; di pembayaran digunakan untuk membatasi satu pembayaran per pesanan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 15. Kenapa CHECK?
**Jawaban:** Agar aturan nilai juga dijaga oleh database.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 16. Kenapa password_hash?
**Jawaban:** Password tidak disimpan plaintext; yang disimpan adalah hash.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 17. Kenapa password_verify?
**Jawaban:** Membandingkan password input dengan hash tersimpan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 18. Apa fungsi session?
**Jawaban:** Menyimpan state identitas user antar request.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 19. Kenapa session_regenerate_id?
**Jawaban:** Mengganti session ID setelah login untuk mengurangi risiko session fixation.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 20. Apa itu CSRF?
**Jawaban:** Request lintas situs yang mencoba memanfaatkan session korban untuk melakukan perubahan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 21. Kenapa token disimpan di session?
**Jawaban:** Agar server memiliki nilai rahasia yang dapat dibandingkan dengan token dari form.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 22. Kenapa hash_equals?
**Jawaban:** Membandingkan token dengan cara yang dirancang aman terhadap timing attack.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 23. Apa itu XSS?
**Jawaban:** Konten/script berbahaya yang dapat dirender sebagai HTML di browser.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 24. Apa fungsi htmlspecialchars?
**Jawaban:** Meng-escape karakter khusus HTML saat output.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 25. Apa itu SQL Injection?
**Jawaban:** Manipulasi input agar menjadi bagian dari sintaks SQL.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 26. Kenapa beginTransaction?
**Jawaban:** Karena satu aksi bisnis mengubah beberapa data yang harus konsisten.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 27. Apa fungsi commit?
**Jawaban:** Mengesahkan perubahan transaction.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 28. Apa fungsi rollback?
**Jawaban:** Membatalkan perubahan transaction yang belum commit.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 29. Kenapa SELECT FOR UPDATE?
**Jawaban:** Mengunci row yang sedang diproses agar pemeriksaan dan perubahan bersifat konsisten.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 30. Kenapa stok dikembalikan saat edit/delete?
**Jawaban:** Karena stok sebelumnya sudah dikurangi oleh detail pesanan lama.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 31. Kenapa meja dicek sebelum pesanan?
**Jawaban:** Satu meja hanya boleh memiliki satu pesanan aktif pada satu waktu.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 32. Kenapa Lunas harus sama dengan total?
**Jawaban:** Aplikasi menetapkan validasi bahwa pembayaran Lunas harus tepat sebesar total pesanan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 33. Kenapa bayar tidak otomatis Selesai?
**Jawaban:** Status finansial dan status pelayanan adalah dua hal berbeda.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 34. Kenapa meja baru dikosongkan lewat aksi khusus?
**Jawaban:** Pelanggan masih dapat duduk setelah pesanan selesai dilayani.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 35. Apa fungsi RETURNING id?
**Jawaban:** PostgreSQL dapat mengembalikan ID row yang baru diinsert tanpa query SELECT terpisah.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 36. Kenapa credential memakai environment variable?
**Jawaban:** Agar secret tidak tertanam di source code/repository.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 37. Apa fungsi require?
**Jawaban:** Memasukkan file yang dibutuhkan; kegagalan require menghentikan eksekusi.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 38. Kenapa header diikuti exit?
**Jawaban:** Agar script berhenti setelah response redirect.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 39. Kenapa validasi tetap perlu jika ada constraint database?
**Jawaban:** Validasi memberi kontrol alur/error di aplikasi; constraint menjaga integritas di database.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 40. Kenapa menggunakan JOIN?
**Jawaban:** Untuk mengambil data terkait dari tabel berbeda berdasarkan relasi.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 41. Kenapa detail_pesanan terpisah?
**Jawaban:** Satu pesanan dapat memiliki banyak item; tabel detail merepresentasikan baris item.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 42. Kenapa index dibuat?
**Jawaban:** Mempercepat lookup/join pada kolom yang sering digunakan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 43. Kenapa FETCH_ASSOC?
**Jawaban:** Hasil fetch diakses dengan nama kolom sehingga lebih jelas.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 44. Kenapa ID di-cast int?
**Jawaban:** Memastikan tipe data ID sesuai yang diharapkan dan membantu validasi.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 45. Kenapa strtotime?
**Jawaban:** Memastikan string tanggal dapat diparse sebelum dikonversi ke format database.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 46. Kenapa status dicek dengan in_array?
**Jawaban:** Membatasi input hanya pada daftar status yang diperbolehkan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 47. Kenapa menu_id dan jumlah harus array?
**Jawaban:** Form pesanan mengirim banyak item sehingga struktur input berupa array.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 48. Kenapa item menu dijumlahkan berdasarkan menuId?
**Jawaban:** Jika menu yang sama muncul lebih dari sekali, jumlah dapat digabung sebelum diproses.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 49. Kenapa cek rowCount setelah update stok?
**Jawaban:** Untuk memastikan tepat satu row berhasil diubah; jika tidak, kondisi stok mungkin sudah berubah.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 50. Kenapa ambil oldDetails saat edit?
**Jawaban:** Agar stok dari pesanan lama dapat dikembalikan sebelum menerapkan detail baru.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 51. Kenapa meja lama dan baru diperhatikan saat edit?
**Jawaban:** Supaya perpindahan meja tidak meninggalkan meja lama tetap terisi atau memilih meja baru yang sudah dipakai.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 52. Kenapa delete detail sebelum insert detail baru saat edit?
**Jawaban:** Untuk mengganti isi detail secara utuh setelah stok lama dipulihkan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 53. Kenapa pembayaran mengecek row pesanan dengan FOR UPDATE?
**Jawaban:** Agar total/status pesanan yang menjadi dasar pembayaran tidak berubah bersamaan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 54. Kenapa cek pembayaran sebelum insert?
**Jawaban:** Untuk mencegah satu pesanan memiliki pembayaran ganda.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 55. Kenapa catch Throwable?
**Jawaban:** Agar kegagalan/error pada transaction dapat ditangani dan rollback dilakukan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 56. Apa fungsi auth.php?
**Jawaban:** Membatasi halaman agar hanya user login yang dapat mengaksesnya.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 57. Apa yang dilakukan logout?
**Jawaban:** Mengakhiri session/login sehingga user tidak lagi dianggap terautentikasi.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 58. Apa fungsi role?
**Jawaban:** Menyimpan peran user untuk kebutuhan kontrol akses/penampilan fitur.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 59. Apa tujuan laporan?
**Jawaban:** Menyajikan data agregat/rekap untuk penjualan, pelanggan, atau menu terlaris.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 60. Kenapa search server-side?
**Jawaban:** Filter dilakukan database sehingga aplikasi tidak perlu mengambil seluruh data ke browser.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 61. Kenapa security harus berlapis?
**Jawaban:** Tidak ada satu mekanisme yang menggantikan semua: prepared statement, validation, escaping, CSRF, session protection punya tujuan berbeda.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 62. Apa yang terjadi saat deploy?
**Jawaban:** Source aplikasi dipasang pada environment hosting; konfigurasi database production diberikan melalui environment variable.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 63. Jika route 404, apa dicek?
**Jawaban:** URL, folder root, route Vercel/router, nama file, dan apakah file benar-benar ada.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 64. Jika database tidak ditemukan?
**Jawaban:** Periksa DB_NAME, host/port, environment variable, dan keberadaan database di server.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 65. Jika Undefined array key?
**Jawaban:** Cek nama field form dan gunakan default `??` bila input memang opsional.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 66. Kenapa transaction mencegah data setengah berubah?
**Jawaban:** Jika error terjadi sebelum commit, rollback membatalkan perubahan transaction.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

## 67. Bagaimana menjawab pertanyaan kode?
**Jawaban:** Sebut fungsi → alasan → tunjuk bagian kode → jelaskan dampak perubahan.

**Follow-up yang mungkin:** `Kenapa?`, `Apa yang terjadi jika dihapus?`, `Di file mana konsep ini dipakai?`

