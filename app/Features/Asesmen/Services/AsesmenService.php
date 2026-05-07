<?php

namespace App\Features\Asesmen\Services;

use App\Models\Asesmen;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AsesmenService
{
    public function store(Kunjungan $kunjungan, array $data): Asesmen
    {
        if ($kunjungan->status === Kunjungan::STATUS_BATAL) {
            throw ValidationException::withMessages([
                'kunjungan' => 'Kunjungan batal tidak dapat dibuatkan asesmen.',
            ]);
        }

        if ($kunjungan->asesmen()->exists()) {
            throw ValidationException::withMessages([
                'kunjungan' => 'Kunjungan ini sudah memiliki asesmen.',
            ]);
        }

        return DB::transaction(function () use ($kunjungan, $data) {
            $asesmen = $kunjungan->asesmen()->create($data);
            $kunjungan->update(['status' => Kunjungan::STATUS_SUDAH_ASESMEN]);

            return $asesmen->load('kunjungan.pasien');
        });
    }

    public function update(Asesmen $asesmen, array $data): Asesmen
    {
        return DB::transaction(function () use ($asesmen, $data) {
            $asesmen->update($data);

            return $asesmen->fresh(['kunjungan.pasien', 'kunjungan.poli', 'kunjungan.dokter']);
        });
    }
}
