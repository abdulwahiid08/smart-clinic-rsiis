<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'polis';

    protected $fillable = [
        'nama_poli',
        'deskripsi',
        'created_by',
        'updated_by',
    ];

    public function dokters(): HasMany
    {
        return $this->hasMany(Dokter::class);
    }

    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
