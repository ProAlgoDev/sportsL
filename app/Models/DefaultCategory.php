<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultCategory extends Model
{
    public $table = 'defaultcategory';
    protected $fillable = [
        'teamId',
        'defaultCategory'
    ];
    use HasFactory;
}
