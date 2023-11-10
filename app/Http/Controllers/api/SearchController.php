<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Author;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        // Search all media
        $media = [];

        // Playlists
        $playlists = Playlist::addSelect([
            'id', 'user_id', 'title', 'cover',
            'author' => User::select('name')
                ->whereColumn('user_id', 'users.id')
                ->limit(1)
        ])->with(['tracks' => function ($q) {
            return $q->addSelect(DB::raw('CONCAT("playlist-", playlist_track.playlist_id, "-", tracks.id) AS uid'));
        }])
            ->where('playlists.title', 'like', "%{$request->title}%")
            ->get();

        $media = array_merge($media, $playlists->toarray());


        // Albums
        $albums = Album::addSelect([
            'id', 'author_id', 'title', 'cover', 'release_date',
            'author' => Author::select('name')
                ->whereColumn('author_id', 'authors.id')
                ->limit(1)
        ])->with(['tracks' => function ($q) {
            return $q->addSelect(DB::raw('CONCAT("album-", album_id, "-", tracks.id) AS uid'));
        }])
            ->where('albums.title', 'like', "%{$request->title}%")
            ->get();

        $media = array_merge($media, $albums->toarray());


        // Tracks
        $tracks = Track::addSelect([
            'id', 'album_id', 'title', 'duration',
            'cover' => Album::select('cover')
                ->whereColumn('album_id', 'albums.id')
                ->limit(1),
            'author_id' => Album::select('author_id')
                ->whereColumn('album_id', 'albums.id')
                ->limit(1),
            'author' => Author::select('name')
                ->whereColumn('author_id', 'authors.id')
                ->limit(1)
        ])->with(['album'])
            ->where('tracks.title', 'like', "%{$request->title}%")
            ->get();

        $media = array_merge($media, $tracks->toarray());


        return $media;
    }
}
