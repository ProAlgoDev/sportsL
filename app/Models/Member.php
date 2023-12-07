<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    public $table = 'member';

    protected $fillable = [
        'approved',
        'userId',
        'team_id'
    ];
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
