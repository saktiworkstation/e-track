<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\UserTicket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){
        return view('dashboard.ticket.index',[
            'tickets' => UserTicket::where('user_id', auth()->user()->id)->get()
        ]);
    }

    public function create(){
        //
    }

    public function store(){
        //
    }
}
