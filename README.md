# Aplikasi Rawat Jalan RSI Ibnu Sina

Project test skill Laravel 10 untuk pencatatan pasien rawat jalan. Aplikasi memakai feature pattern, validasi input, service transaction, relasi Eloquent, query laporan berfilter, login sederhana, seed data, dan Docker.

## Fitur

- Login/logout sederhana tanpa role.
- CRUD master data Poli dan Dokter.
- Pendaftaran pasien baru atau kunjungan untuk pasien lama.
- Nomor antrean otomatis per tanggal kunjungan dan poli.
- Edit data pendaftaran.
- Batal kunjungan dengan validasi status.
- Asesmen rawat jalan yang terhubung ke kunjungan.
- Edit asesmen dan riwayat asesmen pasien.
- Laporan kunjungan dengan filter nama pasien, tanggal, dokter, diagnosis, dan status.
- Ringkasan total kunjungan sesuai filter.
- Export laporan ke CSV.
- Sidebar responsif yang bisa dibuka/tutup.

## Akun Demo

```text
Email: admin@rsi.test
Password: password
```

## Struktur Feature

```text
app/Features
|-- Asesmen
|-- Auth
|-- Dashboard
|-- Kunjungan
|-- Laporan
`-- MasterData
```

Setiap fitur berisi controller, request validation, service, dan route sesuai kebutuhan. Operasi pendaftaran, edit kunjungan, batal kunjungan, simpan asesmen, edit asesmen, serta CRUD master data memakai `DB::transaction()`.

## Menjalankan Dengan Docker

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Buka aplikasi:

```text
http://localhost:8080
```

Adminer untuk cek database:

```text
http://localhost:8081
Server: mysql
Username: rsi
Password: secret
Database: rsi_ibnusina
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

- `/login` halaman login.
- `/` dashboard ringkasan.
- `/master/polis` master poli.
- `/master/dokters` master dokter.
- `/kunjungans` daftar pendaftaran pasien.
- `/kunjungans/create` form pendaftaran pasien.
- `/laporan` laporan kunjungan dan export CSV.
