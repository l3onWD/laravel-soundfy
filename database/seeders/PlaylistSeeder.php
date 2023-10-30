<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get system playlists
        $playlists = config('data.playlists');

        // Get all initial tracks
        $track_ids = Track::pluck('id')->toArray();

        foreach ($playlists as $playlist) {

            $new_playlist = new Playlist();

            $new_playlist->author_id = $playlist['author_id'];
            $new_playlist->title = $playlist['title'];
            $new_playlist->cover = $playlist['cover'];

            $new_playlist->save();


            // Add random tracks
            $playlist_tracks = [];
            foreach ($track_ids as $track_id) {
                if (rand(0, 1)) $playlist_tracks[] = $track_id;
            }

            // Add at least 1 track
            if (empty($playlist_tracks)) Arr::random($track_ids);

            $new_playlist->tracks()->attach($playlist_tracks);
        }
    }
}
