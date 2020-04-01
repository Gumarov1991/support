<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['can' => 'admin-panel']);
    }

    public function index(Ticket $ticket)
    {
        $tickets = $ticket->sortable()->paginate(5);

        return view('admin.index', compact('tickets'));
    }
}
