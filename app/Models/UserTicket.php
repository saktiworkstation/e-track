<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTicket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Tickets()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
