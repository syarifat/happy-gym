<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BookingPt extends Model
{
    protected $primaryKey = 'booking_id'; // Penting!
    protected $fillable = [
        'member_paket_id', 
        'instruktur_id', 
        'tanggal_sesi', 
        'jam_sesi', 
        'status', 
        'alasan_penolakan', 
        'saran_tanggal', 
        'saran_jam', 
        'waktu_scan_qr'
    ];

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id', 'instruktur_id');
    }

    public function memberPaket()
    {
        return $this->belongsTo(MemberPaketPt::class, 'member_paket_id', 'member_paket_id');
    }
}