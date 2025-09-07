<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    
    public function run(): void
    {
       
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Add 3 favorite tracks
            $tracks = Track::inRandomOrder()->take(3)->get();
            foreach ($tracks as $track) {
                $user->favorites()->create([
                    'favorable_id'   => $track->id,
                    'favorable_type' => Track::class,
                ]);
            }

            // Add 2 favorite albums
            $albums = Album::inRandomOrder()->take(2)->get();
            foreach ($albums as $album) {
                $user->favorites()->create([
                    'favorable_id'   => $album->id,
                    'favorable_type' => Album::class,
                ]);
            }
        } 
    }
}
