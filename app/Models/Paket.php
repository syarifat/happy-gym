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
        'harga_diskon',
        'tanggal_akhir_diskon',
        'durasi',
    ];

    protected $appends = ['is_diskon_aktif'];

    public function getIsDiskonAktifAttribute()
    {
        if ($this->harga_diskon && $this->tanggal_akhir_diskon) {
            return \Carbon\Carbon::now()->startOfDay()->lte(\Carbon\Carbon::parse($this->tanggal_akhir_diskon)->startOfDay());
        }
        return false;
    }

    /**
     * Relasi ke PemesananPaket (Opsi jika nanti dibutuhkan)
     */
    public function pemesanan()
    {
        return $this->hasMany(PemesananPaket::class, 'paket_id', 'paket_id');
    }
}