<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFisikMember extends Model
{
    use HasFactory;

    protected $table = 'data_fisik_members';
    protected $primaryKey = 'data_fisik_id';

    protected $fillable = [
        'member_id',
        'tinggi_badan',
        'berat_badan',
        'umur',
        'massa_otot'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
