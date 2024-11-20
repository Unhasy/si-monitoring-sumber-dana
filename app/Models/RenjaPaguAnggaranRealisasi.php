<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenjaPaguAnggaranRealisasi extends Model
{
    use HasFactory;

    protected $table = 'renja_pagu_anggaran_realisasi';

    protected $fillable = [
        'realisasi',
        'pagu',
    ];
}
