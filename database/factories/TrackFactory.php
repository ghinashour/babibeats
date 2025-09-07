<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    protected $model = Track::class;

    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'artist_id' => Artist::factory(),
            'title' => $this->faker->sentence(2),
            'duration_seconds' =>$this->faker->numberBetween(120,420), //2-7minutes
        ];
    }
}
