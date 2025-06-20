<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class EventController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        // Apply auth middleware to protected routes
        $this->middleware('auth:sanctum')->except(['index', 'show']);

        // Register resource authorization
        $this->authorizeResource(Event::class, 'event', [
            'except' => ['register', 'cancelRegistration'],
        ]);
    }

    /**
     * Get all upcoming events (paginated)
     */
    public function index()
    {
        $events = Event::with('organizer')
            ->upcoming()
            ->paginate(10);

        return EventResource::collection($events);
    }

    /**
     * Create a new event
     */
    public function store(EventRequest $request)
    {
        $validated = $request->validated();
        $event = $request->user()->events()->create($validated);

        return new EventResource($event->load('organizer'));
    }

    /**
     * Get a single event
     */
    public function show(Event $event)
    {
        return new EventResource($event->load(['organizer', 'attendees']));
    }

    /**
     * Update an existing event
     */
    public function update(EventRequest $request, Event $event)
    {
        $validated = $request->validated();
        $event->update($validated);

        return new EventResource($event->fresh());
    }

    /**
     * Delete an event
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }

    /**
     * Register authenticated user for an event
     */
    public function register(Request $request, Event $event)
    {
        $request->validate([
            'user_id' => 'sometimes|exists:users,id'
        ]);

        $userId = $request->input('user_id', $request->user()->id);

        // Prevent duplicate registration
        if (!$event->attendees()->where('user_id', $userId)->exists()) {
            $event->attendees()->attach($userId);
        }

        return response()->json([
            'message' => 'Registered successfully',
            'data' => new EventResource($event->fresh())
        ]);
    }

    /**
     * Cancel event registration
     */
    public function cancelRegistration(Request $request, Event $event)
    {
        $userId = $request->input('user_id', $request->user()->id);
        $event->attendees()->detach($userId);

        return response()->json([
            'message' => 'Registration cancelled',
            'data' => new EventResource($event->fresh())
        ]);
    }
}
