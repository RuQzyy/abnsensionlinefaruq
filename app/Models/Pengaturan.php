<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id_pengaturan';
    public $timestamps = false;
    protected $fillable = [
        'absen_datang',
        'absen_pulang',
        'long_lokasi',
        'lath_lokasi',
        'radius_absen',
    ];
}
