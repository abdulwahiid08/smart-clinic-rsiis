<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'pasiens';

    protected $fillable = [
        'kode_pasien',
        'nama_pasien',
        'jenis_kelamin',
        'tanggal_lahir',
        'nomor_hp',
        'alamat',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
