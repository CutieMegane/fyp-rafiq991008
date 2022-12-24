<?php

namespace App\Http\Controllers;

use App\Models\Certs;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
