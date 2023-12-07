<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    public $table = 'team';
    protected $fillable = [
        'teamId',
        'teamName',
        'owner',
        'sportsType',
        'area',
        'age',
        'sex'
    ];
    public function memeber()
    {
        return $this->hasOne(Member::class);
    }
}
