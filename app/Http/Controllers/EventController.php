<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.event.index', [
            'events' => Event::latest()->get(),
            'title' => 'Events',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255|unique:events',
            'published_at' => 'required|date',
            'content' => 'required'
        ]);

        Event::create($validatedData);

        return redirect('/dashboard/events')->with('success', 'New event has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('dashboard.event.edit', [
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $rules = [
            'published_at' => 'required|date',
            'content' => 'required'
        ];

        if ($request->title != $event->title) {
            $rules['title'] = 'required|max:255|unique:events';
        }

        $validatedData = $request->validate($rules);

        Event::where('id', $event->id)->update($validatedData);

        return redirect('/dashboard/events')->with('success', 'Event has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Event::destroy($event->id);
        return redirect('/dashboard/events')->with('success', 'Event has been deleted!');
    }
}
