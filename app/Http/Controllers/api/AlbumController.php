<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
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
        // Get Album media
        $album = Album::select('albums.id', 'albums.author_id', 'albums.title', 'albums.cover', 'albums.release_date', 'authors.name AS author')
            ->join('authors', 'authors.id', '=', 'albums.author_id')
            ->with('tracks')
            ->find($id);

        // Send 404 if not found
        if (!$album) return response(NULL, 404);

        // Send Album
        return response()->json($album);
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
     * Display Random albums.
     */
    public function random()
    {
        // Create albums media
        $albumsMedia = Album::select('albums.id', 'albums.author_id', 'albums.title', 'albums.cover', 'albums.release_date', 'authors.name AS author')
            ->join('authors', 'authors.id', '=', 'albums.author_id')
            ->with('tracks')
            ->inRandomOrder()
            ->limit(2)
            ->get();

        return response()->json($albumsMedia);
    }
}
