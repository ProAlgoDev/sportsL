<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamAreaList extends Model
{
    use HasFactory;
    public $table = 'area_list';
    protected $fillable = [
        'areaId',
        'areaName'
    ];
}
