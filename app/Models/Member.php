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
    ];
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function getTeamAvatarAttribute()
    {
        return $this->team->teamAvatar;
    }
    public function getTeamIdAttribute()
    {
        return $this->team->teamId;
    }
    public function getTeamNameAttribute()
    {
        return $this->team->teamName;
    }
}
