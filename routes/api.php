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

Route::get('/tracks/random', function () {

    $tracks = Track::select('id', 'album_id', 'title', 'duration')->with(['album'])->inRandomOrder()->limit(4)->get();

    return response()->json($tracks);
});

Route::get('/tracks', function () {

    $tracks = Track::select('id', 'album_id', 'title', 'duration')->with(['album'])->get();

    return response()->json($tracks);
});


// Playlist routes
Route::get('/playlists/our-picks', function () {

    $playlists = Playlist::select('playlists.id', 'playlists.user_id', 'playlists.title', 'playlists.cover', 'users.name AS author')
        ->where('user_id', 1)
        ->join('users', 'users.id', '=', 'playlists.user_id')
        ->with('tracks')
        ->get();

    return response()->json($playlists);
});


// Album Routes
Route::get('/albums/random', function () {

    $albums = Album::select('albums.id', 'albums.author_id', 'albums.title', 'albums.cover', 'albums.release_date', 'authors.name AS author')
        ->join('authors', 'authors.id', '=', 'albums.author_id')
        ->with('tracks')
        ->inRandomOrder()
        ->limit(2)
        ->get();

    return response()->json($albums);
});
