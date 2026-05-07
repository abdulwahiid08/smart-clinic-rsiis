<?php

namespace Database\Seeders;

use App\Models\Asesmen;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $umum = Poli::firstOrCreate(
                ['nama_poli' => 'Poli Umum'],
                ['deskripsi' => 'Pelayanan pemeriksaan umum rawat jalan.']
            );

            $anak = Poli::firstOrCreate(
                ['nama_poli' => 'Poli Anak'],
                ['deskripsi' => 'Pelayanan kesehatan anak dan tumbuh kembang.']
            );

            $penyakitDalam = Poli::firstOrCreate(
                ['nama_poli' => 'Poli Penyakit Dalam'],
                ['deskripsi' => 'Pelayanan penyakit dalam dan kontrol kronis.']
            );

            $dokterUmum = Dokter::firstOrCreate(
                ['nama_dokter' => 'dr. Andini Prameswari'],
                ['poli_id' => $umum->id, 'spesialis' => 'Dokter Umum']
            );

            $dokterAnak = Dokter::firstOrCreate(
                ['nama_dokter' => 'dr. Bima Satria, Sp.A'],
                ['poli_id' => $anak->id, 'spesialis' => 'Spesialis Anak']
            );

            $dokterDalam = Dokter::firstOrCreate(
                ['nama_dokter' => 'dr. Citra Lestari, Sp.PD'],
                ['poli_id' => $penyakitDalam->id, 'spesialis' => 'Spesialis Penyakit Dalam']
            );

            $pasien = Pasien::firstOrCreate(
                ['kode_pasien' => 'PSN-20260507-0001'],
                [
                    'nama_pasien' => 'Ahmad Fauzi',
                    'jenis_kelamin' => 'L',
                    'tanggal_lahir' => '1991-08-17',
                    'nomor_hp' => '081234567890',
                    'alamat' => 'Jl. Melati No. 10',
                ]
            );

            $kunjungan = Kunjungan::firstOrCreate(
                ['kode_kunjungan' => 'KJG-20260507-0001'],
                [
                    'pasien_id' => $pasien->id,
                    'poli_id' => $dokterDalam->poli_id,
                    'dokter_id' => $dokterDalam->id,
                    'tanggal_kunjungan' => today(),
                    'jenis_pembayaran' => 'bpjs',
                    'status' => Kunjungan::STATUS_SUDAH_ASESMEN,
                ]
            );

            Asesmen::firstOrCreate(
                ['kunjungan_id' => $kunjungan->id],
                [
                    'keluhan_utama' => 'Demam dan batuk sejak tiga hari.',
                    'tekanan_darah' => '120/80',
                    'suhu_tubuh' => 38.2,
                    'berat_badan' => 68.5,
                    'diagnosis_awal' => 'Infeksi saluran pernapasan akut',
                    'tindakan_terapi' => 'Terapi simptomatik dan kontrol ulang bila keluhan memberat.',
                    'catatan_dokter' => 'Anjurkan istirahat cukup dan hidrasi.',
                ]
            );

            Pasien::firstOrCreate(
                ['kode_pasien' => 'PSN-20260507-0002'],
                [
                    'nama_pasien' => 'Siti Rahma',
                    'jenis_kelamin' => 'P',
                    'tanggal_lahir' => '1987-03-12',
                    'nomor_hp' => '089876543210',
                    'alamat' => 'Jl. Kenanga No. 22',
                ]
            );

            Kunjungan::firstOrCreate(
                ['kode_kunjungan' => 'KJG-20260507-0002'],
                [
                    'pasien_id' => Pasien::where('kode_pasien', 'PSN-20260507-0002')->value('id'),
                    'poli_id' => $dokterUmum->poli_id,
                    'dokter_id' => $dokterUmum->id,
                    'tanggal_kunjungan' => today(),
                    'jenis_pembayaran' => 'umum',
                    'status' => Kunjungan::STATUS_TERDAFTAR,
                ]
            );
        });
    }
}
