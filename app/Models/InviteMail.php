<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteMail extends Model
{
    use HasFactory;
    public $table = 'inviteemail';
    protected $fillable = [
        'teamId',
        'email',
        'token',
        'expired_at'
    ];
}
