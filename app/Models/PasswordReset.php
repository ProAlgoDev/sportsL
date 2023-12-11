<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {
    use HasFactory;
    public $table = 'passwordreset';
    protected $fillable = [
        'token',
        'user_id',
        'expired_at'
    ];
}
