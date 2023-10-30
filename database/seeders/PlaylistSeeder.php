<?php

namespace Database\Seeders;

use App\Models\Playlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get system playlists
        $playlists = config('data.playlists');

        foreach ($playlists as $playlist) {

            $new_playlist = new Playlist();

            $new_playlist->author_id = $playlist['author_id'];
            $new_playlist->title = $playlist['title'];
            $new_playlist->cover = $playlist['cover'];

            $new_playlist->save();
        }
    }
}
