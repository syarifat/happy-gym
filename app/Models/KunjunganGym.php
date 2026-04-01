<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunjunganGym extends Model
{
    protected $table = 'kunjungan_gyms';
    protected $primaryKey = 'kunjungan_id';
    
    protected $fillable = [
        'member_id', 
        'lokasi_id', 
        'tanggal', 
        'waktu_masuk', 
        'waktu_keluar', 
        'status_kunjungan'
    ];
}