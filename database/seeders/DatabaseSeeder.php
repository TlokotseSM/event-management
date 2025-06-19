<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Organizer User',
            'email' => 'organizer@example.com',
            'role' => 'organizer',
        ]);

        User::factory(10)->create();

        Event::factory(20)->create();
    }
}
