<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAbsensi extends Model
{
    use HasFactory;

    protected $table = 'booking_absensis';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'member_id',
        'jadwal_id',
        'instruktur_id',
        'tanggal',
        'status_booking',
        'status_hadir',
    ];

    /**
     * Relasi: Booking ini dilakukan oleh seorang Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    /**
     * Relasi: Booking ini merujuk pada Jadwal tertentu
     */
    public function jadwal()
    {
        return $this->belongsTo(JadwalLatihan::class, 'jadwal_id', 'jadwal_id');
    }

    /**
     * Relasi: Booking ini diawasi oleh Instruktur tertentu
     */
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id', 'instruktur_id');
    }
}