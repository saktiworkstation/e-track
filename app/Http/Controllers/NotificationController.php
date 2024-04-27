<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.notification.index',[
            'title' => 'Notification',
            'notifications' => Notification::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.notification.create', [
            'users' => User::orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'link' => 'required|url',
            'message' => 'required'
        ]);

        $validatedData['status'] = 1;

        Notification::create($validatedData);

        return redirect('/dashboard/notifications')->with('success', 'New notifications has been sended!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        return view('dashboard.notification.edit', [
            'users' => User::orderBy('name', 'ASC')->get(),
            'notification' => $notification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $rules = [
            'user_id' => 'required',
            'link' => 'required|url',
            'message' => 'required'
        ];

        $validatedData = $request->validate($rules);

        notification::where('id', $notification->id)->update($validatedData);

        return redirect('/dashboard/notifications')->with('success', 'Notification has been chnged!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        Notification::destroy($notification->id);
        return redirect('/dashboard/notifications')->with('success', 'Notification has been deleted!');
    }

    public function userPage(){
        return view('dashboard.notification.user', [
            'title' => 'My Notification',
            'notifications' => Notification::where('user_id', auth()->user()->id)->get()
        ]);
    }
}
