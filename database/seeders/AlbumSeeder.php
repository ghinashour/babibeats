<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    
    public function run(): void
    {
       // 10 albums with tracks (if you want independent from ArtistSeeder)
        Album::factory()
            ->count(10)
            ->hasTracks(5)
            ->create();
    }
}
