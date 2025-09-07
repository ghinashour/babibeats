<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListeningHistorySeeder extends Seeder
{
    
    public function run(): void
    {
          $users = User::all();

        foreach ($users as $user) {
            // Each user has 10 listening history records
            $tracks = Track::inRandomOrder()->take(10)->get();
            foreach ($tracks as $track) {
                $user->listeningHistory()->create([
                    'track_id'  => $track->id,
                    'played_at' => now()->subMinutes(rand(1, 1000)),
                ]);
            }
        }
    }
}
