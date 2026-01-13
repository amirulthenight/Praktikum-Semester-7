<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = "laporans";

    protected $fillable = [
        'nik_pelapor',
        'foto',
        'koordinat',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
        'status',
    ];
}
