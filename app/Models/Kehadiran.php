<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran';
    public $timestamps = false;
   protected $fillable = [
        'id_users',
        'tanggal',
        'waktu_datang',
        'waktu_pulang',
        'foto',
        'lokasi',
        'jenis',
        'status_datang',
        'status_pulang',
    ];

}
