<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Acara extends Model
{
    protected $table = 'acaras';
    protected $primaryKey = 'id_acara';

    protected $fillable = [
        'nama',
        'tanggal',
        'lokasi',
        'status',
        'pengguna_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke User (pembuat / pengelola acara)
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function kelasLombas(): HasMany
    {
        return $this->hasMany(KelasLomba::class, 'acara_id', 'id_acara');
    }
}