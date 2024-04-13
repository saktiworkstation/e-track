<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class LandPageController extends Controller
{
    public function index(){
        return view('landing-page', [
            'tickets' => Ticket::orderBy('created_at', 'asc')->paginate(6)
        ]);
    }
}
