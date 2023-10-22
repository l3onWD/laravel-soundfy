<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //todo Get authors data
        $authors = config('data.authors_list');

        foreach ($authors as $author) {
            $new_author = new Author();

            $new_author->name = $author;

            $new_author->save();
        }
    }
}
