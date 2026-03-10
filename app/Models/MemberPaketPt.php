<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MemberPaketPt extends Model
{
    protected $primaryKey = 'member_paket_id'; // Penting!
    protected $fillable = ['member_id', 'paket_id', 'sisa_sesi', 'expired_date', 'status'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}