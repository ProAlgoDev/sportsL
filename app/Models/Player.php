<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    public $table = 'player';
    protected $fillable = [
        'name',
        'gender',
        'teamId',
        'createdDate',
        'status',
        'register'
    ];
}
