<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MemberPaketPt extends Model
{
    protected $primaryKey = 'member_paket_id'; // Penting!
    protected $fillable = ['member_id', 'paket_id', 'instruktur_id', 'sisa_sesi', 'expired_date', 'status'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id', 'instruktur_id');
    }

    // Relasi untuk mengambil semua jadwal booking dari paket ini
    public function bookingPts()
    {
        return $this->hasMany(BookingPt::class, 'member_paket_id', 'member_paket_id');
    }
}