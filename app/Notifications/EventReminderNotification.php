<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Event Reminder: ' . $this->event->title)
            ->line('This is a reminder for your upcoming event.')
            ->line('Event: ' . $this->event->title)
            ->line('Date: ' . $this->event->start_date->format('M j, Y g:i a'))
            ->line('Location: ' . $this->event->location)
            ->action('View Event', url('/events/'.$this->event->id))
            ->line('Thank you for using our application!');
    }
}
