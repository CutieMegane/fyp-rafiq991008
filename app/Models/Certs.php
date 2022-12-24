<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Certs extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'certs';

    protected $fillable = [
        'name',
        'details',
        'created_by',
        'image',
        'hash',
        'stego_mark'
    ];
}
