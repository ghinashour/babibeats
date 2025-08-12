<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   public function run()
{
    \App\Models\User::factory(5)->create()->each(function($user){
        // each user gets 2 playlists
        \App\Models\Playlist::factory(2)->create(['user_id'=>$user->id]);
    });

    \App\Models\Artist::factory(10)->create()->each(function($artist){
        $albums = \App\Models\Album::factory(2)->create(['artist_id'=>$artist->id]);
        foreach($albums as $album){
            \App\Models\Track::factory(5)->create(['album_id'=>$album->id, 'artist_id' => $artist->id]);
        }
    });

    // Create some favorites and listening history
    $user = \App\Models\User::first();
    \App\Models\Track::inRandomOrder()->take(10)->get()->each(function($track) use ($user){
        $user->favorites()->create(['favoritable_type'=>\App\Models\Track::class, 'favoritable_id'=>$track->id]);
        \App\Models\ListeningHistory::create([
            'user_id'=>$user->id,
            'track_id'=>$track->id,
            'played_at'=>now()->subMinutes(rand(1,1000)),
            'duration_played'=>rand(30, $track->duration_seconds ?? 180)
        ]);
    });

    // attach some tracks to playlists
    \App\Models\Playlist::all()->each(function($pl){
        $tracks = \App\Models\Track::inRandomOrder()->take(8)->pluck('id');
        $position = 1;
        foreach($tracks as $t){
           $pl->tracks()->attach($t, ['position'=>$position++]);
        }
    });
}

}
