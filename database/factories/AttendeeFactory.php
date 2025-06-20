<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendeeFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'event_id' => \App\Models\Event::factory(),
            'status' => $this->faker->randomElement(['registered', 'attended', 'cancelled']),
            'attended_at' => $this->faker->optional()->dateTimeThisYear(),
        ];
    }
}
