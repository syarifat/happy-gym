<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable 
{
    use Notifiable;

    protected $table = 'members';
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'nama', 'email', 'password', 'no_hp', 'status_membership', 
        'tanggal_mulai_member', 'tanggal_berakhir_member'
    ];

    protected $hidden = [
        'password',
    ];
}