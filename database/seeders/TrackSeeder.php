<?php

namespace Database\Seeders;

use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //todo Get track data
        $tracks = config('data.tracks_list');

        foreach ($tracks as $track) {

            $new_track = new Track();

            $new_track->title = $track['title'];
            $new_track->src = $track['src'];
            $new_track->duration = $track['duration'];

            $new_track->save();
        }
    }
}
