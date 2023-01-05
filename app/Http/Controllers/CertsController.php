<?php

namespace App\Http\Controllers;

use App\Models\Certs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CertsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certs = Certs::all();
        return view('certs.index', compact('certs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('certs.create');
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
            'image' => ['required', 'image'],
        ]);

        $hash = Hash::make($request['image']);
        if ($hash == Certs::where('hash', $hash))
            return with('success2', 'Same file exists');
        else {
            Certs::create([
                'name' => $request['name'],
                'details' => $request['details'],
                'image' => base64_encode($request['image']),
                'hash' => Hash::make($request['image']),
                'created_by' => Auth::user()->name,
                'created_at' => now(),
            ]);
        }

        return redirect()->route('certs.index')->with('success', 'New certs created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certs  $certs
     * @return \Illuminate\Http\Response
     */
    public function show(Certs $certs)
    {
        //
    }

    public function downloadImage(Certs $certs)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certs  $certs
     * @return \Illuminate\Http\Response
     */
    public function edit(Certs $certs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certs  $certs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certs $certs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certs  $certs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certs $certs)
    {
        //
    }
}
