# Vercel — Cheat Sheet UTS

| Bagian | Fungsi |
|---|---|
| `vercel.json` | konfigurasi runtime + route |
| `api/index.php` | router server-side |
| `REQUEST_URI` | URI yang diminta browser |
| `parse_url()` | mengambil bagian path |
| `urldecode()` | decode URL |
| `str_starts_with()` | cek prefix path |
| `substr()` | mengambil bagian string |
| `is_file()` | mengecek file ada |
| `require` | menjalankan PHP |
| `readfile()` | mengirim isi file |
| `Content-Type` | memberi tahu jenis response |
| `404` | resource tidak ditemukan |

### Kalimat hafalan

> **`vercel.json` mengarahkan request; `api/index.php` menentukan file yang harus dilayani.**
