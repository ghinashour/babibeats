<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   public function run()
{
     // Call seeders in the proper order
        $this->call([
            UserSeeder::class,
            ArtistSeeder::class,
            AlbumSeeder::class,
            TrackSeeder::class,
            PlaylistSeeder::class,
            FavoritesSeeder::class,
            ListeningHistorySeeder::class,
        ]);
}

}
