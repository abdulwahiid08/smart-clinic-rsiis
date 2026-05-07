<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kunjungan extends Model
{
    use HasFactory;
    use HasUuids;

    public const STATUS_TERDAFTAR = 'terdaftar';
    public const STATUS_SUDAH_ASESMEN = 'sudah_asesmen';
    public const STATUS_BATAL = 'batal';

    protected $table = 'kunjungans';

    protected $fillable = [
        'kode_kunjungan',
        'pasien_id',
        'poli_id',
        'dokter_id',
        'tanggal_kunjungan',
        'nomor_antrean',
        'jenis_pembayaran',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    public function asesmen(): HasOne
    {
        return $this->hasOne(Asesmen::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', '!=', self::STATUS_BATAL);
    }

    public function scopeFilterLaporan($query, array $filters)
    {
        return $query
            ->when(filled($filters['nama_pasien'] ?? null), function ($query) use ($filters) {
                $query->whereHas('pasien', fn ($pasien) => $pasien->where('nama_pasien', 'like', '%' . $filters['nama_pasien'] . '%'));
            })
            ->when(filled($filters['tanggal_kunjungan'] ?? null), fn ($query) => $query->whereDate('tanggal_kunjungan', $filters['tanggal_kunjungan']))
            ->when(filled($filters['dokter_id'] ?? null), fn ($query) => $query->where('dokter_id', $filters['dokter_id']))
            ->when(filled($filters['diagnosis'] ?? null), function ($query) use ($filters) {
                $query->whereHas('asesmen', fn ($asesmen) => $asesmen->where('diagnosis_awal', 'like', '%' . $filters['diagnosis'] . '%'));
            })
            ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('status', $filters['status']));
    }
}
