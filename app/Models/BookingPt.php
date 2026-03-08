<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BookingPt extends Model
{
    protected $table = 'booking_pts';
    protected $primaryKey = 'booking_id';
    protected $fillable = ['member_paket_id', 'ketersediaan_id', 'status', 'waktu_scan_qr'];

    public function ketersediaan()
    {
        return $this->belongsTo(KetersediaanInstruktur::class, 'ketersediaan_id', 'ketersediaan_id');
    }

    public function memberPaket()
    {
        return $this->belongsTo(MemberPaketPt::class, 'member_paket_id', 'member_paket_id');
    }
}