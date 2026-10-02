# 04 — Integrasi Transaksi JS12

## Alur

Pilih meja → buat pesanan → stok berkurang → bayar → pembayaran Lunas →
pesanan tetap Proses → makanan datang → status Selesai → pelanggan selesai makan →
Kosongkan Meja → meja Kosong.

## Transaction

JS12 menggunakan:

```php
$pdo->beginTransaction();
...
$pdo->commit();
```

dan ketika error:

```php
if ($pdo->inTransaction()) {
    $pdo->rollBack();
}
```

## Mengapa penting?

Pesanan menyentuh beberapa data sekaligus: `pesanan`, `detail_pesanan`, `menu.stok`,
dan `meja.status`. Tanpa transaction, satu bagian dapat berhasil sementara bagian
lain gagal.

## Locking

`SELECT ... FOR UPDATE` dipakai pada row yang harus konsisten, misalnya meja dan
pesanan.

## Stok

Saat pesanan aktif diproses, stok dikurangi. Saat pesanan aktif diedit/dihapus,
stok lama dikembalikan terlebih dahulu.

## Pembayaran

Status `Lunas` harus sama dengan total pesanan. `Belum Lunas` tidak boleh lebih
besar dari total pesanan.

## Kosongkan meja

`kosongkan_meja.php` menolak proses jika pesanan belum `Selesai`.
