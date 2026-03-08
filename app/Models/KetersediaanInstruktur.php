<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KetersediaanInstruktur extends Model
{
    protected $table = 'ketersediaan_instrukturs';
    protected $primaryKey = 'ketersediaan_id';
    protected $fillable = ['instruktur_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'is_booked'];

    public function booking()
    {
        return $this->hasOne(BookingPt::class, 'ketersediaan_id', 'ketersediaan_id');
    }
}