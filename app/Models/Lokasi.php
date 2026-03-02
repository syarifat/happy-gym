<?php

namespace App\Models; //

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasis'; //
    protected $primaryKey = 'lokasi_id'; //

    protected $fillable = [
        'nama_cabang',
        'kota',
        'alamat',
        'foto',
        'deskripsi',
        'jam_buka',
        'fasilitas_klub',
        'alat_gym',
        'link_google_maps'
    ];

    // Relasi ke Instruktur (1 Cabang punya Banyak Instruktur)
    public function instrukturs()
    {
        return $this->hasMany(Instruktur::class, 'lokasi_id', 'lokasi_id');
    }
}