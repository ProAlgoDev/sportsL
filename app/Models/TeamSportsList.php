<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamSportsList extends Model
{
    use HasFactory;
    public $table = 'sports_list';
    protected $fillable = [
        'sportsId',
        'sportsType'
    ];
}
