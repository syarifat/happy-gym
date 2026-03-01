<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';
    protected $primaryKey = 'pengumuman_id';

    protected $fillable = [
        'admin_id',
        'judul',
        'deskripsi',
        'foto',
        'tanggal_post',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}