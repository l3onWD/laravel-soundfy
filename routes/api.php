<?php

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Track Routes
Route::get('/tracks/{track}/stream', function (Track $track) {

    // Create a bynary stream
    $response = new BinaryFileResponse(storage_path() . $track->src);
    BinaryFileResponse::trustXSendfileTypeHeader();

    // Send response
    return $response;
});

Route::get('/tracks', function () {

    $tracks = Track::with('album', 'album.author')->get();

    return response()->json($tracks);
});
