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
Route::prefix('/playlists')->controller(PlaylistController::class)->group(function () {
    Route::get('/our-picks', 'ourPicks');
    Route::get('/{playlist}', 'show');
});


// Album Routes
Route::prefix('/albums')->controller(AlbumController::class)->group(function () {
    Route::get('/random', 'random');
    Route::get('/{album}', 'show');
});


// Track Routes
Route::prefix('/tracks')->controller(TrackController::class)->group(function () {
    Route::get('/{track}/stream', 'stream');
    Route::get('/random', 'random');
    Route::get('/{track}', 'show');
});
