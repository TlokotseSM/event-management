<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    public function definition()
    {
        $types = ['image/jpeg', 'image/png', 'application/pdf'];

        return [
            'file_name' => $this->faker->word().'.'.$this->faker->fileExtension(),
            'file_path' => 'uploads/'.$this->faker->uuid(),
            'mime_type' => $this->faker->randomElement($types),
            'size' => $this->faker->numberBetween(1000, 10000000),
            'disk' => 'public',
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
