<?php

namespace App\Http\Controllers;

use App\Models\Certs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
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
        if(Auth::user()->operator == 0){
            $certs = Certs::where('created_by', 'like', Auth::user()->name)->get()->sortBy('name');
            return view('certs.index', compact('certs'));
        } else{
            $certs = Certs::all()->sortBy('name');
            return view('certs.index', compact('certs'));
        }
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
        //Pre-initialization of written paths
        CertsController::checkPaths();

        //Validate uploaded images
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone_no' => ['nullable', 'numeric','min_digits:9', 'max_digits:11'],
            'image' => ['required', 'image'],
        ]);

        $hess = hash_file("sha256", $request->image->path());

        if (Certs::where('hash', '=',  $hess)->exists()) {
            return redirect()->route('certs.index')->with('success2', 'Same file already exists.');
        } else {
            //Preset path, and keys
            $temp = storage_path("app/" . $request->image->store('temp'));
            $paff = storage_path("app/public/images/") . CertsController::rngString(40) . ".png";
            $stego_mark = CertsController::rngString(25);
            
            //Steganography etching magick
            $stegoEngine = new Processor;
            try {
                $stegoResult = $stegoEngine->encode($temp, $stego_mark);
            } catch (Exception $c) {
                return redirect()->route('certs.index')->with('success2', 'Apparently you hit this uncommon limitation with gd() library and Adobe ICC color profile. Please use any tools to fix the image first.');
            }
            $stegoResult->write($paff);
            
            //Hash for quick check
            $hess = hash_file("sha256", $paff);

            Certs::create([
                'name' => $request['name'],
                'details' => $request['details'],
                'email' => $request['email'],
                'phone_no' => $request['phone_no'],
                'imagepath' => $paff,
                'hash' => $hess,
                'stego_mark' => $stego_mark,
                'created_by' => Auth::user()->name,
                'created_at' => now(),
            ]);

            //Cleanup
            unlink($temp);
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

    public function certValidator(Request $request){
        //Prevent weird bugs
        CertsController::checkPaths();

        if (!Validator::make($request->all(), ['file' => 'mimes:zip',])->fails()) {
            $zip = new ZipArchive;
            $zip->open($request->file("file")->getRealPath());
            
            //check if zip is generated by us or not, our zip only have single image
            if ($zip->count() > 1)
                return redirect()->route('home')->with('success2', 'This compressed zip is modified. Our zip file have only single image inside. :)');
            
            $fname = $zip->getNameIndex(0);
            $zip->extractTo(storage_path("app/temp/"));
            $zip->close();
            $img = storage_path("app/temp/" . $fname);
            $needCleanup = true;
        }
        else {
            $img = $request->file->path();
            $needCleanup = false;
        }

        //check if png
        if (pathinfo($img, PATHINFO_EXTENSION) == "png" || !Validator::make($request->all(), ['file' => 'mimes:png',])->fails()) {
            $hess = hash_file("sha256", $img);
            $stego = new Processor;
            try { //if steganography not exist it will return error, simple library weaknesses
                $stego_mark = $stego->decode($img);
            } catch (\Throwable $th) {
                $stego_mark = null;
            }

            //zip temp cleanup within loop- all key is in memory already
            if ($needCleanup) unlink($img);

            //check with hash first, if mismatch, stego also will mismatch
            if (Certs::where('hash', '=',  $hess)->exists()) {

                //check stego integrity, maybe file is forged with hash collision (low chance)
                if (Certs::where('stego_mark', '=', $stego_mark) -> exists())
                    return redirect()->route('certs.show', Certs::where('stego_mark', '=', $stego_mark)->first());
                else {
                    $cert = Certs::where('hash', '=', $hess)->first();
                    return view('certs.partshow', compact('cert'));
                }
            }
            else return redirect()->route('home')->with('success2', 'No matching found in database, the files might be processed, compressed or modified.'); 
        }
        //quirks - need to cleanup before return. Return calls break execution
        else $message = 'This system only generates file in PNG format, please check your uploaded files.';

        //zip temp cleanup outside loop 
        if ($needCleanup) unlink($img);

        //return with error only after cleanup
        return redirect()->route('home')->with('success2', $message);
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
    private function rngString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    private function checkPaths() {
        if (!File::exists(storage_path("app/temp")))
            File::makeDirectory(storage_path("app/temp"), 0755, true);

        if (!File::exists(storage_path("app/public/images")))
            File::makeDirectory(storage_path("app/public/images"), 0755, true);
    }
}
