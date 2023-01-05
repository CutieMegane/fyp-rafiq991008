<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Jenssegers\Mongodb\Eloquent\Model;

class Certs extends Model
{
    use HasFactory;
    //protected $connection = 'mongodb';
    //protected $collection = 'certs';

    protected $fillable = [
        'name',
        'details',
        'created_by',
        'created_at',
        'imagepath',
        'hash',
        'stego_mark'
    ];
}
