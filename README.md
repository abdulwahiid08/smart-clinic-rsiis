# Aplikasi Rawat Jalan RSI Ibnu Sina

Project test skill Laravel 10 untuk pencatatan pasien rawat jalan. Aplikasi memakai feature pattern, validasi input, service transaction, relasi Eloquent, query laporan berfilter, seed data, dan Docker.

## Fitur

- Pendaftaran pasien dan kunjungan rawat jalan.
- Edit data pendaftaran.
- Batal kunjungan dengan validasi status.
- Asesmen rawat jalan yang terhubung ke kunjungan.
- Edit asesmen dan riwayat asesmen pasien.
- Laporan kunjungan dengan filter nama pasien, tanggal, dokter, diagnosis, dan status.
- Ringkasan total kunjungan sesuai filter.

## Struktur Feature

```text
app/Features
├── Asesmen
├── Dashboard
├── Kunjungan
└── Laporan
```

Setiap fitur berisi controller, request validation, service, dan route sesuai kebutuhan. Operasi pendaftaran, edit kunjungan, batal kunjungan, simpan asesmen, dan edit asesmen memakai `DB::transaction()`.

## Menjalankan Dengan Docker

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Buka aplikasi di:

```text
http://localhost:8080
```

## Menjalankan Tanpa Docker

Pastikan PHP 8.1+, Composer, dan MySQL/MariaDB tersedia.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Jika menjalankan lokal tanpa Docker, sesuaikan `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`.

## Halaman Utama

- `/` dashboard ringkasan.
- `/kunjungans` daftar pendaftaran pasien.
- `/kunjungans/create` form pendaftaran pasien.
- `/laporan` laporan kunjungan.
