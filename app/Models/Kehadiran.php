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
        'waktu',
        'foto',
        'lokasi',
        'status',
    ];
}
