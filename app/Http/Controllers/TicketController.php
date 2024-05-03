<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\UserTicket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'userTickets' => UserTicket::where('status', 1)->latest()->get(),
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
        return redirect('/dashboard/tickets/manage')->with('success', 'Ticket has been deleted!');
    }

    public function useTicket(){
        return view('dashboard.ticket.use-ticket');
    }

    public function submitTicket(Request $request){
        $ticket = UserTicket::where('code', $request->code)->firstOrFail();

        $newdata = [];

        $oldStatus = $ticket->status;
        $newStatus = 0;
        if($oldStatus == 0){
            $newStatus = $oldStatus + 1;
            $newdata['status'] = $newStatus;
            UserTicket::where('id', $ticket->id)->update($newdata);
            return redirect('/dashboard/tickets')->with('success', 'Ticket successfully used, waiting for confirmation!');
        }elseif($oldStatus == 1){
            return redirect('/dashboard/tickets')->with('success', 'Tickets await confirmation!');
        }else {
            return redirect('/dashboard/tickets')->with('success', 'Ticket has been used, please use another ticket!');
        }
    }

    public function ticketConfirmation($id){
        $ticket = UserTicket::where('id', $id)->firstOrFail();

        $newdata = [];

        $oldStatus = $ticket->status;
        $newStatus = 0;
        if($oldStatus == 1){
            $newStatus = $oldStatus + 1;
            $newdata['status'] = $newStatus;
            UserTicket::where('id', $id)->update($newdata);
            return redirect('/dashboard/tickets/manage')->with('success', 'Ticket confirmed successfully!');
        }elseif($oldStatus == 0){
            return redirect('/dashboard/tickets/manage')->with('success', 'Tickets await use by user!');
        }else {
            return redirect('/dashboard/tickets/manage')->with('success', 'Ticket has been confirmed, please use another ticket!');
        }
    }

    public function userReport(){
        return view('dashboard.ticket.user-report', [
            'userTickets' => UserTicket::latest()->get()
        ]);
    }

    public function buyForm($id){
        return view('dashboard.ticket.buy-ticket', [
            'tickets' => Ticket::latest()->get(),
            'ticketId' => $id
        ]);
    }

    public function buyTicket(Request $request, $id){
        $ticket = Ticket::where('id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $price = $ticket->price;
        $amount = $request->amount;
        $total_price = $price * $amount;

        $uniqueCode = uniqid();

        while (UserTicket::where('code', $uniqueCode)->exists()) {
            $uniqueCode = uniqid();
        }

        $validatedData['code'] = $uniqueCode;

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['ticket_id'] = $id;
        $validatedData['status'] = 0;
        $validatedData['total_price'] = $total_price;

        UserTicket::create($validatedData);

        return redirect('/dashboard/tickets')->with('success', 'Ticket purchase successful!');
    }
}
