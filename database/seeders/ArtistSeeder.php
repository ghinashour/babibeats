<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    
    public function run(): void
    {
        //create 5 artists , each with 2 albums , each album has 5 tracks
        Artist::factory()
        ->count(5)
        ->hasAlbums(2, fn($album) =>
        $album -> hasTracks(5)
        ) -> create();
    }
}
