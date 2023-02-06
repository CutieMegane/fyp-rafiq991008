<?php

namespace App\Models;

use App\Traits\uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Jenssegers\Mongodb\Eloquent\Model;

class Certs extends Model
{
    use HasFactory, uuids;
    //protected $connection = 'mongodb';
    //protected $collection = 'certs';

    protected $fillable = [
        'name',
        'details',
        'email',
        'phone_no',
        'created_by',
        'created_at',
        'imagepath',
        'hash',
        'stego_mark'
    ];
}
