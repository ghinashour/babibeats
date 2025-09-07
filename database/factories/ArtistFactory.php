<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{

    protected $model = \App\Models\Artist::class;

    public function definition():array
    {
        return [
            'name'=> $this -> faker-> name,
            'bio' => $this ->faker -> paragraph,
        ];
    }
}
