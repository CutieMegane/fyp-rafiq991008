<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertsAPI;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*//*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//Route::get('retrieve', [CertsAPI::class, 'show']);
Route::post('verify', [CertsAPI::class, 'certValidator']); 
Route::get('download', [CertsAPI::class, 'downloadCert']);
Route::get('index', [CertsAPI::class, 'index']);
Route::post('registerNoty', [CertsAPI::class, 'registerNotification']);
