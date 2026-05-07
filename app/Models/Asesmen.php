<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asesmen extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'asesmens';

    protected $fillable = [
        'kunjungan_id',
        'keluhan_utama',
        'tekanan_darah',
        'suhu_tubuh',
        'berat_badan',
        'diagnosis_awal',
        'tindakan_terapi',
        'catatan_dokter',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'suhu_tubuh' => 'decimal:1',
        'berat_badan' => 'decimal:2',
    ];

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }
}
