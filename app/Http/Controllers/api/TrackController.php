<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
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
        // Get Track media
        $track = Track::select('tracks.id', 'tracks.album_id', 'tracks.title', 'tracks.duration', 'albums.cover AS cover', 'authors.name AS author')
            ->join('albums', 'albums.id', '=', 'tracks.album_id')
            ->join('authors', 'authors.id', '=', 'albums.author_id')
            ->with(['album'])
            ->find($id);

        // Send 404 if not found
        if (!$track) return response(NULL, 404);

        // Send Track
        return response()->json($track);
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
     * Stream the specified track.
     */
    public function stream(string $id)
    {
        $track = Track::find($id);

        // Send 404 if not found
        if (!$track) return response(NULL, 404);

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
    }

    /**
     * Display Random tracks.
     */
    public function random()
    {
        // Create tracks media
        $tracksMedia = Track::select('tracks.id', 'tracks.album_id', 'tracks.title', 'tracks.duration', 'albums.cover AS cover', 'authors.name AS author')
            ->join('albums', 'albums.id', '=', 'tracks.album_id')
            ->join('authors', 'authors.id', '=', 'albums.author_id')
            ->with(['album'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return response()->json($tracksMedia);
    }
}
