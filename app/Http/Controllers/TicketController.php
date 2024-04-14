<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\UserTicket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index(){
        return view('dashboard.ticket.index',[
            'userTickets' => UserTicket::where('user_id', auth()->user()->id)->latest()->get(),
            'tickets' => Ticket::latest()->get(),
            'title' => 'My Tickets',
        ]);
    }

    public function manage(){
        return view('dashboard.ticket.index',[
            'userTickets' => UserTicket::latest()->get(),
            'tickets' => Ticket::latest()->get(),
            'title' => 'Ticket Management',
        ]);
    }

    public function create(){
        return view('dashboard.ticket.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:tickets',
            'stocks' => 'required|numeric',
            'status' => 'required|numeric',
            'price' => 'required|numeric',
            'descriptions' => 'required'
        ]);

        Ticket::create($validatedData);

        return redirect('/dashboard/tickets/manage')->with('success', 'New ticket has been added!');
    }

    public function edit($id){
        return view('dashboard.ticket.edit', [
            'ticket' => Ticket::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id){
        $ticket = Ticket::findOrFail($id);

        $rules = [
            'stocks' => 'required|numeric',
            'status' => 'required|numeric',
            'price' => 'required|numeric',
            'descriptions' => 'required'
        ];

        if ($request->name != $ticket->name) {
            $rules['name'] = 'required|max:255|unique:tickets';
        }

        $validatedData = $request->validate($rules);

        Ticket::where('id', $ticket->id)->update($validatedData);

        return redirect('/dashboard/tickets/manage')->with('success', 'Ticket has been updated!');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->image) {
            Storage::delete($ticket->image);
        }

        Ticket::destroy($ticket->id);
        return redirect('/dashboard/tickets')->with('success', 'Ticket has been deleted!');
    }
}
