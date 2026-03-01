<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananPaket extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_pakets';
    protected $primaryKey = 'pemesanan_id';

    // Sesuaikan fillable dengan kolom di migrasi Anda
    protected $fillable = [
        'member_id',
        'paket_id',
        'instruktur_id',
        'status_persetujuan',
        'tanggal_pesan',
    ];

    /**
     * Relasi ke Member (Siapa yang memesan)
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    /**
     * Relasi ke Paket (Paket apa yang dipilih)
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id', 'paket_id');
    }

    /**
     * Relasi ke Instruktur (Jika paketnya adalah Personal Training)
     */
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id', 'instruktur_id');
    }
}