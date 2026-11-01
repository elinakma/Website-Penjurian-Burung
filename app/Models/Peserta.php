<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'kelas_lomba_id',
        'acara_id',
        'burung_id',
        'nama_burung',
        'alamat',
        'harga',
        'nomor_gantangan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasLomba()
    {
        return $this->belongsTo(KelasLomba::class, 'kelas_lomba_id', 'id_kelas');
    }

    public function acara()
    {
        return $this->belongsTo(Acara::class, 'acara_id', 'id_acara');
    }

    public function burung()
    {
        return $this->belongsTo(Burung::class, 'burung_id');
    }
    
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'peserta_id');
    }
}