<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pakets';

    // Primary Key yang kita gunakan di migration
    protected $primaryKey = 'paket_id';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama_paket',
        'jenis',
        'harga',
        'durasi',
    ];

    /**
     * Relasi ke PemesananPaket (Opsi jika nanti dibutuhkan)
     */
    public function pemesanan()
    {
        return $this->hasMany(PemesananPaket::class, 'paket_id', 'paket_id');
    }
}