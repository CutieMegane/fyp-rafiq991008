<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authEngine extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirector()
    {
        $check = User::all();
        if ($check->isEmpty()) {
            return view('init');
        } else if (Auth::check()){
            return view('home');
        } else
            return view('login');
            
    }

    public function firstInit(Request $data)
    {
        $data->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $logMeIn = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'operator' => true,
            'last_login' => now(),
        ]);

        Auth::login($logMeIn);
        return redirect('/');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string:50'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function deauth(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function username() {
        return Auth::user()->username;
    }

    public function index()
    {
        $z = User::all();

        return view('user.index', compact('z'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['nullable','string', 'max:100', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ]);


        if ($request['operator'] == "on") $op = 1;
        else $op = 0;

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'operator' => $op
        ]);

        return redirect()->route('useradd.index')->with('success', 'New staff added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     *//*
    public function show(User $user)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $useradd)
    {
        return view('user.edit', compact('useradd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $useradd)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $useradd->name = $request['name'];
        $useradd->email = $request['email'];
        if (!($request->password == 'null')) {
            $useradd->password = Hash::make($request->password);
        }
        $useradd->operator = $request['operator'];
        $useradd->save();

        return redirect()->route('useradd.index')->with('success', 'New staff added.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $useradd)
    {
        if (User::all()->count() == 1) {
            return redirect()->route('useradd.index')->with('success2', "You are the loner here, please don't delete yourself.");
        } else if (auth()->user()->id == $useradd->id) {
            return redirect()->route('useradd.index')->with('success2', "Don't, please.");
        } else {
            $useradd->delete();
            return redirect()->route('useradd.index')->with('success2', 'User deleted');
        }
    }
}
