<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Burung extends Model
{
    protected $table = 'jenis_burung';

    protected $fillable = [
        'nama',
    ];
}