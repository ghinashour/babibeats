<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    public function run(): void
    {
       // 5 playlists per user
        \App\Models\User::all()->each(function ($user) {
            Playlist::factory()
                ->count(3)
                ->for($user)
                ->create()
                ->each(function ($playlist) {
                    // attach random tracks to each playlist
                    $tracks = Track::inRandomOrder()->take(5)->pluck('id');
                    $playlist->tracks()->attach($tracks);
                });
            }); 
    }
}
