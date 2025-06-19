<?php

// app/Policies/EventPolicy.php
namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function update(User $user, Event $event)
    {
        return $user->id === $event->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Event $event)
    {
        return $user->id === $event->user_id || $user->role === 'admin';
    }
}
