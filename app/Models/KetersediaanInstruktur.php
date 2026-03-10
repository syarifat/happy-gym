<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KetersediaanInstruktur extends Model
{
    protected $primaryKey = 'ketersediaan_id'; // Penting!
    protected $fillable = ['instruktur_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'is_booked'];

    public function booking()
    {
        return $this->hasOne(BookingPt::class, 'ketersediaan_id', 'ketersediaan_id');
    }
    
    protected $casts = [
        'is_booked' => 'boolean',
    ];
}