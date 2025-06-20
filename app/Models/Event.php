<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'price',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relationships
    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'attendees')
                   ->using(Attendee::class)
                   ->withPivot('status')
                   ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // Scopes
    public function scopeUpcoming(Builder $query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopePast(Builder $query)
    {
        return $query->where('end_date', '<', now());
    }

    // Helpers
    public function isFull()
    {
        return $this->attendees()->count() >= $this->capacity;
    }
}
