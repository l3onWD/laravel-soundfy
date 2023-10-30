<?php

use App\Models\Album;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    // Get File Data
    $file_name = $track->file_name;
    $file_path = storage_path('tracks/' . $file_name);
    $file_content = file_get_contents($file_path);
    $file_size = filesize($file_path);

    // Set mime type
    $mime_type = "audio/mpeg";

    // Set Headers
    $headers = [
        'Accept-Ranges: 0-' . ($file_size - 1),
        'Content-Length:' . $file_size,
        'Content-Type:' . $mime_type,
        'Content-Disposition: inline; filename="' . $file_name . '"'
    ];

    return response($file_content, 200, $headers);
});

Route::get('/tracks', function () {

    $tracks = Track::with('album', 'album.author')->get();

    return response()->json($tracks);
});


// Playlist routes
Route::get('/playlists/our-picks', function () {

    $playlists = Playlist::select('id', 'user_id', 'title', 'cover')->where('user_id', 1)->with(['user', 'tracks'])->get();

    return response()->json($playlists);
});


// Album Routes
Route::get('/albums/random', function () {

    $albums = Album::select('id', 'author_id', 'title', 'release_date')->with(['author', 'tracks'])->inRandomOrder()->limit(2)->get();

    return response()->json($albums);
});
