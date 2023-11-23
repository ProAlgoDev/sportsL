<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table = 'category';
    protected $fillable = [
        'teamId'
    ];
    protected $casts = [
        'categoryList' => 'array'
    ];
}
