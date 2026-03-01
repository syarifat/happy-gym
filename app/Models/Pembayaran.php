<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $primaryKey = 'pembayaran_id';

    protected $fillable = [
        'pemesanan_id', 'member_id', 'order_id', 'transaction_id', 
        'metode', 'jumlah', 'status', 'snap_token', 'tanggal_bayar'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function pemesanan()
    {
        return $this->belongsTo(PemesananPaket::class, 'pemesanan_id', 'pemesanan_id');
    }
}