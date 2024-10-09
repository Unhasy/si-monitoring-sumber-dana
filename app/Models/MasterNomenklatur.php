<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterNomenklatur extends Model
{
    use HasFactory;

    protected $table = 'master_nomenklatur';
    protected $fillable = [
        'master_dasar_hukum_id',
        'kategori',
        'kode_rekening',
        'nomenklatur',
        'user_pembuat',
    ];

}
