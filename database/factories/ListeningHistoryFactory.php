<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ListeningHistory;
use App\Models\User;
use App\Models\Track;

class ListeningHistoryFactory extends Factory
{
    protected $model = ListeningHistory:: class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'track_id' => Track::factory(),
            'played_at' => $this -> faker -> dateTimeThisMonth(),
        ];
    }
}
