<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    
    public function run(): void
    {
        // 30 standalone tracks
        Track::factory()->count(30)->create();
    }
}
