<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dokter extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'dokters';

    protected $fillable = [
        'poli_id',
        'nama_dokter',
        'spesialis',
        'created_by',
        'updated_by',
    ];

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
