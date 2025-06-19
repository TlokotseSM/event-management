<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    protected $signature = 'send:event-reminders';
    protected $description = 'Send reminders for upcoming events';

    public function handle()
    {
        $events = Event::whereBetween('start_date', [
            now()->addDay(),
            now()->addDay()->addHours(24)
        ])->get();

        foreach ($events as $event) {
            foreach ($event->attendees as $attendee) {
                $attendee->notify(new EventReminderNotification($event));
            }
        }

        $this->info('Reminders sent successfully!');
    }
}
