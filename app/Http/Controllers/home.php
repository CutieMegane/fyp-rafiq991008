<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class home extends Controller
{
    public function index(){
        if (User::all()->isEmpty()) {
            return view('init');
        } else {
            return view('home');
        }
    }
}
