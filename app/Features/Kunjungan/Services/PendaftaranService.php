<?php

namespace App\Features\Kunjungan\Services;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PendaftaranService
{
    public function store(array $data): Kunjungan
    {
        $this->ensureDoctorBelongsToPoli($data['dokter_id'], $data['poli_id']);

        return DB::transaction(function () use ($data) {
            $pasien = Pasien::create([
                'kode_pasien' => $this->generatePatientCode(),
                'nama_pasien' => $data['nama_pasien'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'nomor_hp' => $data['nomor_hp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);

            return Kunjungan::create([
                'kode_kunjungan' => $this->generateVisitCode(),
                'pasien_id' => $pasien->id,
                'poli_id' => $data['poli_id'],
                'dokter_id' => $data['dokter_id'],
                'tanggal_kunjungan' => $data['tanggal_kunjungan'],
                'jenis_pembayaran' => $data['jenis_pembayaran'],
                'status' => Kunjungan::STATUS_TERDAFTAR,
            ])->load(['pasien', 'poli', 'dokter']);
        });
    }

    public function update(Kunjungan $kunjungan, array $data): Kunjungan
    {
        $this->ensureDoctorBelongsToPoli($data['dokter_id'], $data['poli_id']);

        if ($kunjungan->status === Kunjungan::STATUS_BATAL) {
            throw ValidationException::withMessages([
                'kunjungan' => 'Kunjungan batal tidak dapat diubah.',
            ]);
        }

        return DB::transaction(function () use ($kunjungan, $data) {
            $kunjungan->pasien->update([
                'nama_pasien' => $data['nama_pasien'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'nomor_hp' => $data['nomor_hp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);

            $kunjungan->update([
                'poli_id' => $data['poli_id'],
                'dokter_id' => $data['dokter_id'],
                'tanggal_kunjungan' => $data['tanggal_kunjungan'],
                'jenis_pembayaran' => $data['jenis_pembayaran'],
            ]);

            return $kunjungan->fresh(['pasien', 'poli', 'dokter', 'asesmen']);
        });
    }

    public function cancel(Kunjungan $kunjungan): void
    {
        if ($kunjungan->status === Kunjungan::STATUS_SUDAH_ASESMEN) {
            throw ValidationException::withMessages([
                'kunjungan' => 'Kunjungan yang sudah asesmen tidak dapat dibatalkan.',
            ]);
        }

        DB::transaction(function () use ($kunjungan) {
            $kunjungan->update(['status' => Kunjungan::STATUS_BATAL]);
        });
    }

    private function generatePatientCode(): string
    {
        $sequence = Pasien::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'PSN-' . now()->format('Ymd') . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    private function generateVisitCode(): string
    {
        $sequence = Kunjungan::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'KJG-' . now()->format('Ymd') . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    private function ensureDoctorBelongsToPoli(string $dokterId, string $poliId): void
    {
        $isValid = Dokter::whereKey($dokterId)
            ->where('poli_id', $poliId)
            ->exists();

        if (! $isValid) {
            throw ValidationException::withMessages([
                'dokter_id' => 'Dokter tidak sesuai dengan poli tujuan.',
            ]);
        }
    }
}
