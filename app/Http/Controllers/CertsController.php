<?php

namespace App\Http\Controllers;

use App\Models\Certs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use KzykHys\Steganography\Processor;
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
            //Preset path, and keys
            $temp = storage_path("app/" . $request->image->store('temp'));
            $paff = storage_path("app/public/") . CertsController::rngString(40) . ".png";
            $stego_mark = CertsController::rngString(25);
            
            //Steganography etching magick
            $stegoEngine = new Processor;
            $stegoResult = $stegoEngine->encode($temp, $stego_mark);
            $stegoResult->write($paff);
            
            //Hash for quick check
            $hess = hash_file("sha256", $paff);

            Certs::create([
                'name' => $request['name'],
                'details' => $request['details'],
                'imagepath' => $paff,
                'hash' => $hess,
                'stego_mark' => $stego_mark,
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
        return view('certs.show', compact('cert'));
    }

    #todo unzip, read stego, compare, and return result. Oh, adjust so that stego and hash string available for review
    public function certValidator(Request $request){
        if (!Validator::make($request->all(), ['image' => 'mimes:zip',])->fails())
            dd("weee");
        else {
            $hess = hash_file("sha256", $request->image->path());

            if (Certs::where('hash', '=',  $hess)->exists()) {
                return redirect()->route('certs.show', Certs::where('hash', '=',  $hess)->first());
            } else {
                return redirect()->route('home')->with('success2', 'No matching found in database, the files might be processed/compressed or modified.');
            }
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
        $zip->addFile($cert->imagepath, $name . "." . pathinfo($cert->imagepath, PATHINFO_EXTENSION));
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

    //https://www.geeksforgeeks.org/generating-random-string-using-php/
    public function rngString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
