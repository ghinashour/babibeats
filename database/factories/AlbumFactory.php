<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Album::class;

    public function definition(): array
    {
        return [
            'artist_id' =>Artist::factory(),//auto create artist if not provided
            'title' => $this->faker->sentence(3),
            'released_at' => $this->faker->date(),
        ];
    }
}
