<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Filters\V1\EventFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\V1\EventCollection;
use App\Http\Resources\V1\EventResource;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new EventFilter();
        $queryItems = $filter->transform($request);

        $includeUserData = $request->query('includeuser');
        $includeBookedUsersData = $request->query('includebookedusers');

        $events = Event::where($queryItems)->orderBy('end_date', 'desc');

        if ($includeUserData) {
            $events = $events->with('user');
        }

        if ($includeBookedUsersData) {
            $events = $events->with('users');
        }

        return new EventCollection($events->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $params = [
            ...$request->all(),
            'user_id' => auth()->user()->id,
        ];
        return new EventResource(Event::create($params));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($event->loadMissing('user')->loadMissing('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        return new EventResource($event->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        return Event::destroy($event->id);
    }

    /**
     * Book the event for the logged in user.
     */
    public function book(Event $event)
    {
        $event->users()->attach(auth()->user()->id);
        return new EventResource($event->loadMissing('user')->loadMissing('users'));
    }

    /**
     * Unbook the event for the logged in user.
     */
    public function unbook(Event $event)
    {
        $event->users()->detach(auth()->user()->id);
        return new EventResource($event->loadMissing('user')->loadMissing('users'));
    }
}
