<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensis';
    protected $primaryKey = 'presensi_id';

    protected $fillable = [
        'member_id',
        'instruktur_id',
        'waktu_presensi',
    ];

    // Relasi ke Member (Opsional, untuk laporan)
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    // Relasi ke Instruktur (Opsional, untuk laporan)
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id', 'instruktur_id');
    }
}