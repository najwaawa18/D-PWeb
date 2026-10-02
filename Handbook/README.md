# Handbook UTS Cafe_Najwa — FINAL

## Isi
Handbook ini adalah versi belajar UTS yang menggabungkan:
1. dokumentasi konsep;
2. arsitektur project;
3. database;
4. CRUD/search/pagination;
5. authentication/session;
6. security;
7. integrasi transaksi JS12;
8. deployment;
9. troubleshooting;
10. bank pertanyaan;
11. simulasi;
12. **deep-dive source code** dengan nomor baris;
13. **inventory seluruh source**;
14. perbandingan JS09 → JS12.

## Cara pakai
Mulai dari `index.html`. Setelah paham konsep, buka:
- `docs/deep-dive-source.md`
- `docs/source-inventory.md`
- `docs/evolution.md`
- `docs/uts-drill.md`

## Deployment
Folder ini dapat ditempatkan sebagai:

```text
D-PWeb/
└── Handbook/
    ├── index.html
    ├── assets/
    └── docs/
```

Kemudian diakses melalui `/Handbook/` pada deployment static yang sama.

## Secret
`.env` tidak dimasukkan. Jangan commit credential database.
