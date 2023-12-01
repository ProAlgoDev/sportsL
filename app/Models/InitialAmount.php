<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitialAmount extends Model
{
    public $table = 'initialamount';
    protected $fillable = [
        'amount',
        'teamId',
        'owner',
        'createDate'
    ];
    use HasFactory;
}
