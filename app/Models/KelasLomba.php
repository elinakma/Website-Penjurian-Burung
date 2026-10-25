<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KelasLomba extends Model
{
    protected $table = 'kelas_lomba';
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama',
        'harga',
        'kuota',
        'status',
        'final_at',
        'acara_id',
        'burung_id',
    ];

    protected $casts = [
        'final_at' => 'datetime',
        'harga'    => 'integer',
        'kuota'    => 'integer',
    ];

    /**
     * Relasi ke Acara
     */
    public function acara(): BelongsTo
    {
        return $this->belongsTo(Acara::class, 'acara_id', 'id_acara');
    }

    /**
     * Relasi ke Jenis Burung
     */
    public function burung(): BelongsTo
    {
        return $this->belongsTo(Burung::class, 'burung_id');
    }

    public function juris()
    {
        return $this->belongsToMany(
            User::class,
            'kelas_lomba_juri',   // nama tabel pivot
            'kelas_id',           // foreign key di pivot ke kelas_lomba
            'user_id'             // foreign key di pivot ke users
        )->withTimestamps();
    }
}