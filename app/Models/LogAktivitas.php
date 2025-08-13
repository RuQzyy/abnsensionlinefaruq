<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id';
    public $timestamps = false; // karena hanya pakai created_at manual

    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
        'model',
        'model_id',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    // Relasi opsional jika ingin akses user (tanpa foreign key constraints)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
