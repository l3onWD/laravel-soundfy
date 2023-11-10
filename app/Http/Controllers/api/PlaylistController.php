<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Get Playlist
        $playlist = Playlist::select('playlists.id', 'playlists.user_id', 'playlists.title', 'playlists.cover', 'users.name AS author')
            ->join('users', 'users.id', '=', 'playlists.user_id')
            ->with(['tracks' => function ($q) {
                return $q->addSelect(DB::raw('CONCAT("playlist-", playlist_track.playlist_id, "-", tracks.id) AS uid'));
            }])
            ->find($id);

        // Send 404 if not found
        if (!$playlist) return response(NULL, 404);

        // Send Playlist
        return response()->json($playlist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * Display System playlists.
     */
    public function ourPicks()
    {
        // Create playlists media
        $playlistsMedia = Playlist::select('playlists.id', 'playlists.user_id', 'playlists.title', 'playlists.cover', 'users.name AS author')
            ->where('user_id', 1)
            ->join('users', 'users.id', '=', 'playlists.user_id')
            ->with(['tracks' => function ($q) {
                return $q->addSelect(DB::raw('CONCAT("playlist-", playlist_track.playlist_id, "-", tracks.id) AS uid'));
            }])
            ->get();

        return response()->json($playlistsMedia);
    }
}
