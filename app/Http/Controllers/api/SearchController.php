<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class SearchController extends Controller
{
    /**
     * Return filtered resources.
     */
    public function index(Request $request)
    {

        // Filters validation
        if (!isset($request->title) || mb_strlen($request->title) < 2) return [];


        // Get all media
        $media = [];

        // Playlists
        $playlists = Playlist::select('playlists.id', 'playlists.user_id', 'playlists.title', 'playlists.cover', 'users.name AS author')
            ->join('users', 'users.id', '=', 'playlists.user_id')
            ->with('tracks')
            ->where('playlists.title', 'like', "%{$request->title}%")
            ->get();

        $media['playlists'] = $playlists;

        // Albums
        $albums = Album::select('albums.id', 'albums.author_id', 'albums.title', 'albums.cover', 'albums.release_date', 'authors.name AS author')
            ->join('authors', 'authors.id', '=', 'albums.author_id')
            ->with('tracks')
            ->where('albums.title', 'like', "%{$request->title}%")
            ->get();

        $media['albums'] = $albums;

        // Tracks
        $tracks = Track::select('tracks.id', 'tracks.album_id', 'tracks.title', 'tracks.duration', 'albums.cover AS cover', 'authors.name AS author')
            ->join('albums', 'albums.id', '=', 'tracks.album_id')
            ->join('authors', 'authors.id', '=', 'albums.author_id')
            ->with(['album'])
            ->where('tracks.title', 'like', "%{$request->title}%")
            ->get();

        $media['tracks'] = $tracks;


        return $media;
    }
}
