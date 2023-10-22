<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //todo Get albums data
        $albums = config('data.albums_list');

        foreach ($albums as $album) {

            $new_album = new Album();

            $new_album->author_id = $album['author_id'];
            $new_album->title = $album['title'];
            $new_album->cover = $album['cover'];
            $new_album->release_date = $album['release_date'];

            $new_album->save();
        }
    }
}
