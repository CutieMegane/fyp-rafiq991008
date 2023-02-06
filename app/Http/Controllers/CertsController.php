<?php

namespace App\Http\Controllers;

use App\Models\Certs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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

        $hess = hash_file("sha256", $request->image->path());

        if (Certs::where('hash', '=',  $hess)->exists()) {
            return redirect()->route('certs.index')->with('success2', 'Same file already exists.');
        } else {
            $paff = $request->image->store('public/images');
            Certs::create([
                'name' => $request['name'],
                'details' => $request['details'],
                'imagepath' => $paff,
                'hash' => $hess,
                'created_by' => Auth::user()->name,
                'created_at' => now(),
            ]);
        }

        return redirect()->route('certs.index')->with('success', 'New certs created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certs  $cert
     * @return \Illuminate\Http\Response
     */
    public function show(Certs $cert)
    {
        //dd($cert -> details);
        return view('certs.show', compact('cert'));
    }

    public function certValidator(Request $request){
        $hess = hash_file("sha256", $request->image->path());

        if (Certs::where('hash', '=',  $hess)->exists()) {
            return redirect()->route('certs.show', Certs::where('hash', '=',  $hess)->first());
        } else {
            return redirect()->route('home')->with('success2', 'No matching found in database, the files might be processed/compressed or modified.');
        }
    }

    public function downloadCert(Certs $cert)
    {
        //dd (public_path(Storage::url($cert->imagepath)));
        //random number generator - crash avoidance
        $name = $cert->name . "_" . rand(1000,9999);
    
        //zipping files
        $zip = new ZipArchive;
        $zip->open(public_path($name), ZipArchive::CREATE);
        $zip->addFile(public_path(Storage::url($cert->imagepath)), $name . "." . pathinfo($cert->imagepath, PATHINFO_EXTENSION));
        $zip->close();

        //download?
        return response() -> download(public_path($name), $name)->deleteFileAfterSend(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certs  $cert
     * @return \Illuminate\Http\Response
     */
    public function edit(Certs $cert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certs  $cert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certs $cert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certs  $cert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certs $cert)
    {
        Storage::delete($cert->imagepath);
        $cert->delete();
        return redirect()->route('certs.index')->with('success2', 'Certs revoked.');
    }
}
