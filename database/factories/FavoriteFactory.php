<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Favorite;
use App\Models\User;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'user_id' =>User::factory(),
            'favorable_id'=>null, //so that we can set it manually
            'favorable_type' => null,
            //since they  are polymorphic we set them manually  in a seeder

        ];
    }
}
