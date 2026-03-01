<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_latihans';
    protected $primaryKey = 'jadwal_id';

    protected $fillable = [
        'instruktur_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'jenis_latihan',
        'kuota',
    ];

    /**
     * Relasi: Satu jadwal dimiliki oleh satu Instruktur
     */
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id', 'instruktur_id');
    }

    /**
     * Relasi: Satu jadwal bisa memiliki banyak Booking
     */
    public function bookings()
    {
        return $this->hasMany(BookingAbsensi::class, 'jadwal_id', 'jadwal_id');
    }
}