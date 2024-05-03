<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Midtrans\Transaction;
use App\Models\UserTicket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;

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

    // ? No midtrans
    // public function buyTicket(Request $request, $id){
    //     $ticket = Ticket::where('id', $id)->firstOrFail();

    //     $validatedData = $request->validate([
    //         'amount' => 'required|numeric',
    //     ]);

    //     $price = $ticket->price;
    //     $amount = $request->amount;
    //     $total_price = $price * $amount;

    //     $uniqueCode = uniqid();

    //     while (UserTicket::where('code', $uniqueCode)->exists()) {
    //         $uniqueCode = uniqid();
    //     }

    //     $validatedData['code'] = $uniqueCode;

    //     $validatedData['user_id'] = auth()->user()->id;
    //     $validatedData['ticket_id'] = $id;
    //     $validatedData['status'] = 0;
    //     $validatedData['total_price'] = $total_price;

    //     UserTicket::create($validatedData);

    //     return redirect('/dashboard/tickets')->with('success', 'Ticket purchase successful!');
    // }

    // ? With midtrans
    public function buyTicket(Request $request, $id){
        // Ambil data tiket dari database
        $ticket = Ticket::findOrFail($id);

        // Validasi data input
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
        ]);

        // Hitung total harga
        $price = $ticket->price;
        $amount = $request->amount;
        $total_price = $price * $amount;

        // Set data untuk pembelian tiket
        $data['user_id'] = auth()->user()->id;
        $data['ticket_id'] = $id;
        $data['status'] = 0;
        $data['total_price'] = $total_price;

        // Generate kode unik
        $uniqueCode = uniqid();
        while (UserTicket::where('code', $uniqueCode)->exists()) {
            $uniqueCode = uniqid();
        }
        $data['code'] = $uniqueCode;

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data pembelian tiket ke dalam database
            $userTicket = UserTicket::create($data);

            // Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
            Config::$is3ds = true;

            // Buat transaksi pembayaran dengan Midtrans
            $payload = [
                'transaction_details' => [
                    'order_id' => $userTicket->id,
                    'gross_amount' => $total_price,
                ],
            ];

            $snapToken = Snap::getSnapToken($payload);

            // Commit transaksi database jika berhasil
            DB::commit();

            // Redirect pengguna ke halaman pembayaran Midtrans
            return redirect()->away($snapToken);
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();

            // Redirect pengguna ke halaman yang sesuai setelah pembayaran gagal
            // Misalnya, halaman pembelian ulang atau halaman tiket
            return redirect('/dashboard/tickets')->with('error', 'Failed to purchase ticket. Please try again later.');
        }
    }
}
