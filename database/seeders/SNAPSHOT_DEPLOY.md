# Deploy Snapshot Data Lokal

Paket ini memindahkan data aplikasi dari database lokal ke database VPS.

## Sebelum import

1. Backup database VPS.
2. Pastikan seluruh migration sudah berhasil.
3. Upload folder `database/seeders`, file exporter, dan `storage/app/public` dari paket ini.
4. Jalankan `composer dump-autoload` dan `php artisan optimize:clear`.

## Database target kosong

```bash
php artisan db:seed --class=LocalDatabaseSnapshotSeeder --force
php artisan storage:link
```

## Database target sudah berisi data

Mode merge hanya menambahkan baris yang primary key atau unique key-nya belum ada. Mode ini tidak menghapus data.

Tambahkan sementara ke `.env`:

```env
SNAPSHOT_SEED_ALLOW_MERGE=true
```

Kemudian jalankan:

```bash
php artisan config:clear
php artisan db:seed --class=LocalDatabaseSnapshotSeeder --force
php artisan storage:link
```

Setelah selesai, hapus `SNAPSHOT_SEED_ALLOW_MERGE` dari `.env`, lalu jalankan:

```bash
php artisan optimize:clear
php artisan config:cache
```

Snapshot mengandung data user dan hash password. Jangan simpan ZIP atau JSON ini di direktori publik web.
