<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\UserTicket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
            'name' => 'required|max:255',
            'stocks' => 'required|numeric',
            'status' => 'required|numeric',
            'price' => 'required|numeric',
            'descriptions' => 'required'
        ]);

        Ticket::create($validatedData);

        return redirect('/dashboard/tickets')->with('success', 'New ticket has been added!');
    }

    public function edit(){
        return view('dashboard.ticket.edit');
    }
}
