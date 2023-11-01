<?php

use App\Http\Controllers\api\AlbumController;
use App\Http\Controllers\api\PlaylistController;
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

    // Create tracks media
    $tracksMedia = Track::select('tracks.id', 'tracks.album_id', 'tracks.title', 'tracks.duration', 'albums.cover AS cover', 'authors.name AS author')
        ->join('albums', 'albums.id', '=', 'tracks.album_id')
        ->join('authors', 'authors.id', '=', 'albums.author_id')
        ->with(['album'])
        ->inRandomOrder()
        ->limit(4)
        ->get();

    return response()->json($tracksMedia);
});

Route::get('/tracks', function () {

    $tracks = Track::select('id', 'album_id', 'title', 'duration')->with(['album'])->get();

    return response()->json($tracks);
});


// Playlist routes
Route::get('/playlists/our-picks', [PlaylistController::class, 'ourPicks']);
Route::get('/playlists/{playlist}', [PlaylistController::class, 'show']);


// Album Routes
Route::get('/albums/random', [AlbumController::class, 'random']);
