<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Ubah import ini
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable // <-- Extend ke Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id'; // Beritahu Laravel Primary Key-nya

    protected $fillable = [
        'nama', 'username', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}