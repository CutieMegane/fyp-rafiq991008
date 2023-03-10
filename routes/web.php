<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\home;
use App\Http\Controllers\authEngine;
use App\Http\Controllers\CertsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', [home::class, 'index'])->name('home');                                                      //Main page
Route::get('init', [home::class, 'index']);                                                                 //Catching Nottyboi
Route::post('init', [authEngine::class, 'firstInit'])->name('init');                                        //Startup operator account creation
Route::get('login', [authEngine::class, 'redirector'])->name('login');                                      //Login
Route::post('login', [authEngine::class, 'auth'])->name('login');                                           //Login handler
Route::post('logout', [authEngine::class, 'deauth'])->name('logout');                                       //Logout handler
Route::resource('/user', authEngine::class, ['except' => 'show']) -> middleware('auth');                    //All user CRUD operation
Route::resource('/certs', CertsController::class)->except(['show', 'edit', 'update']) -> middleware('auth');//All certs Create,Delete operation
Route::get('/verify/{cert}', [CertsController::class, 'show']) ->name('certs.show');                //For certs validation that passes both cryptography and steganography, without middleware
Route::get('download/{cert}', [CertsController::class, 'downloadCert'])-> name('certs.download');           //Certs download
Route::post('verify', [CertsController::class, 'certValidator']) -> name('certs.validate');                 //Post to controller, custom


Route::get('ofni', function () {phpinfo();});                                                               //PHP sometimes broke itself