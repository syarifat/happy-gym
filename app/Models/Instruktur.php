<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Instruktur extends Authenticatable
{
    use Notifiable;

    protected $table = 'instrukturs';
    protected $primaryKey = 'instruktur_id';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'spesialisasi',
        'lokasi_id',
        'foto', // Pastikan ini ada
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke tabel Lokasi (Cabang)
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'lokasi_id');
    }
}