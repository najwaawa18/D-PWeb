# Vercel — Gambaran Besar

Project Vercel menggunakan satu deployment untuk melayani beberapa Jobsheet PHP dan project **Jobsheet New**.

Arsitektur utamanya:

```text
Browser
   ↓
URL Vercel
   ↓
vercel.json
   ↓
api/index.php
   ↓
folder project yang sesuai
   ↓
PHP / CSS / JS / gambar
```

## Dua file paling penting

### `vercel.json`
Mengatur runtime dan route.

### `api/index.php`
Bertindak sebagai router di sisi server. Router membaca URL request, menentukan folder/file target, lalu menjalankan atau mengirim file tersebut.

## Catatan

Ini berbeda dengan static hosting sederhana. Karena ada PHP, project membutuhkan runtime PHP dan logika routing agar request dapat diteruskan ke file yang benar.
