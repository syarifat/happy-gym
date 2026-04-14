<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenggunaanPt extends Model
{
    protected $primaryKey = 'riwayat_id';
    
    protected $fillable = [
        'member_paket_id',
        'booking_id',
        'waktu_penggunaan',
        'urutan_sesi',
        'keterangan',
        'cabang_lokasi'
    ];

    public function memberPaket()
    {
        return $this->belongsTo(MemberPaketPt::class, 'member_paket_id', 'member_paket_id');
    }

    public function booking()
    {
        return $this->belongsTo(BookingPt::class, 'booking_id', 'booking_id');
    }
}
