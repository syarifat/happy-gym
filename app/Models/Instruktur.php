<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Instruktur extends Authenticatable 
{
    use Notifiable;

    protected $table = 'instrukturs';
    protected $primaryKey = 'instruktur_id';

    protected $fillable = [
        'nama', 'username', 'password', 'spesialisasi',
    ];

    protected $hidden = [
        'password',
    ];
}