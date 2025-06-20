<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Determine whether the user can view any events.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view events list
    }

    /**
     * Determine whether the user can view the event.
     */
    public function view(User $user, Event $event): bool
    {
        return true; // Anyone can view a single event
    }

    /**
     * Determine whether the user can create events.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'organizer']);
    }

    /**
     * Determine whether the user can update the event.
     */
    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the event.
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can register for events.
     */
    public function register(User $user, Event $event): bool
    {
        // Can't register for past events
        if ($event->end_date < now()) {
            return false;
        }

        // Admins can register anyone, users can only register themselves
        return $user->role === 'admin' || $user->role === 'user';
    }

    /**
     * Determine whether the user can cancel event registration.
     */
    public function cancelRegistration(User $user, Event $event): bool
    {
        // Only allow if user is registered for the event
        // or is admin (who can cancel any registration)
        return $event->attendees->contains($user) || $user->role === 'admin';
    }
}
