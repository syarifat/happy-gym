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
        'lokasi_id', // Tambahkan baris ini
    ];

    // Relasi ke Lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'lokasi_id');
    }

    protected $hidden = [
        'password',
    ];
}