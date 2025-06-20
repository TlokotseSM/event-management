<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    public function definition()
    {
        return [
            'file_name' => $this->faker->word().'.'.$this->faker->fileExtension(),
            'file_path' => 'uploads/'.$this->faker->uuid(),
            'mime_type' => $this->faker->randomElement(['image/jpeg', 'image/png']),
            'size' => $this->faker->numberBetween(1000, 10000000),
            'disk' => 'public',
            'user_id' => \App\Models\User::factory(),
            'mediable_type' => $this->faker->randomElement(['App\Models\Event', 'App\Models\User']),
            'mediable_id' => function (array $attributes) {
                return $attributes['mediable_type']::factory();
            }
        ];
    }
}
