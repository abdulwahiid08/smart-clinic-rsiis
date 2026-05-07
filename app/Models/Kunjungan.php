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
}
