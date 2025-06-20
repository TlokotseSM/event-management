<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $table = 'attendees';

    protected $fillable = [
        'user_id',
        'event_id',
        'status' // ['registered', 'attended', 'cancelled']
    ];

    protected $casts = [
        'attended_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Scopes
    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }
}
