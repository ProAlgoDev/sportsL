<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $table = 'book';
    protected $fillable = [
        'changeDate',
        'item',
        'ioType',
        'teamId',
        'description',
        'serialNumber'

    ];
    use HasFactory;
}
