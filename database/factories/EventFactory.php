<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('+1 week', '+1 year');

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'start_date' => $startDate,
            'end_date' => $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s').' +3 days'),
            'location' => $this->faker->address(),
            'capacity' => $this->faker->numberBetween(10, 500),
            'price' => $this->faker->randomFloat(2, 0, 500),
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
