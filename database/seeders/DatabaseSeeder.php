<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create 2 admins
        \App\Models\User::factory()
            ->count(2)
            ->admin()
            ->create();

        // Create 5 organizers
        \App\Models\User::factory()
            ->count(5)
            ->organizer()
            ->create();

        // Create 50 regular users
        $users = \App\Models\User::factory()
            ->count(50)
            ->create();

        // Create 10 categories
        $categories = \App\Models\Category::factory()
            ->count(10)
            ->create();

        // Create 50 events with relationships
        $events = \App\Models\Event::factory()
            ->count(50)
            ->create();

        // Create attendees
        foreach ($events as $event) {
            $attendees = \App\Models\User::inRandomOrder()
                ->limit(rand(5, $event->capacity))
                ->get();

            $event->attendees()->attach($attendees, [
                'status' => 'registered',
            ]);
        }

        // Create media for events and users
        \App\Models\Media::factory()
            ->count(100)
            ->create([
                'mediable_type' => \App\Models\Event::class,
                'mediable_id' => fn() => \App\Models\Event::all()->random()->id,
            ]);

        \App\Models\Media::factory()
            ->count(50)
            ->create([
                'mediable_type' => \App\Models\User::class,
                'mediable_id' => fn() => \App\Models\User::all()->random()->id,
            ]);
    }
}
