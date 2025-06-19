<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('organizer')->upcoming()->paginate(10);
        return EventResource::collection($events);
    }

    public function store(EventRequest $request)
    {
        $event = $request->user()->events()->create($request->validated());
        return new EventResource($event);
    }

    public function show(Event $event)
    {
        return new EventResource($event->load('organizer', 'attendees'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);
        $event->update($request->validated());
        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return response()->noContent();
    }

    public function register(Request $request, Event $event)
    {
        $request->user()->events()->attach($event);
        return response()->json(['message' => 'Registered successfully']);
    }

    public function cancelRegistration(Request $request, Event $event)
    {
        $request->user()->events()->detach($event);
        return response()->json(['message' => 'Registration cancelled']);
    }
}
