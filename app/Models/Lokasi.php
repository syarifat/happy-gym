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
        'alamat',
        'link_google_maps',
    ]; //
}