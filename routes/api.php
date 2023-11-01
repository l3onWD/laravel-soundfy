<?php

use App\Http\Controllers\api\AlbumController;
use App\Http\Controllers\api\PlaylistController;
use App\Http\Controllers\api\TrackController;
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

// Auth routes
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Playlist routes
Route::get('/playlists/our-picks', [PlaylistController::class, 'ourPicks']);
Route::get('/playlists/{playlist}', [PlaylistController::class, 'show']);


// Album Routes
Route::get('/albums/random', [AlbumController::class, 'random']);
Route::get('/albums/{album}', [AlbumController::class, 'show']);


// Track Routes
Route::get('/tracks/{track}/stream', [TrackController::class, 'stream']);
Route::get('/tracks/random', [TrackController::class, 'random']);
Route::get('/tracks/{track}', [TrackController::class, 'show']);
