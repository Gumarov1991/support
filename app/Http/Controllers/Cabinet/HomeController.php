<?php

namespace App\Http\Controllers\Cabinet;

use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Ticket $ticket)
    {
        $tickets = $ticket->where('user_id', Auth::user()->id)->sortable()->paginate(5);

        return view('cabinet.index', compact('tickets'));
    }
}
