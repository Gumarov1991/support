<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Requests\Tickets\CreateRequest;
use App\Http\Requests\Tickets\MessageRequest;
use App\Mail\CloseTicket;
use App\Mail\NewTicket;
use App\Models\Ticket\Photo;
use App\Models\Ticket\Status;
use App\Models\Ticket\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewMessage;
use Telegram\Bot\Laravel\Facades\Telegram;

class TicketController extends Controller
{
    public function create()
    {
        if (Auth::user()->isAllowedToCreateTickets()) {
            return view('cabinet.tickets.create');
        } else {
            \Session::flash('error', 'Открывать тикеты можно не чаще чем один раз в сутки');
            return redirect()->route('cabinet.home');
        }
    }

    public function store(CreateRequest $request)
    {
        $ticket = Ticket::create([
            'subject' => $request['subject'],
            'content' => $request['content'],
            'user_id' => Auth::user()->id
        ]);

        if ($request->hasfile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $filename = $photo->store('photos', 'public');
                Photo::create([
                    'ticket_id' => $ticket->id,
                    'file' => $filename
                ]);
            }
        }

        Status::create([
            'ticket_id' => $ticket->id
        ]);

        \Mail::to(User::where('id', User::MAIN_ADMIN_ID)->first()->email)->send(new NewTicket($ticket));

        $update = Telegram::getUpdates();
        $idLastUserWriteToBot = $update[count($update) - 1]['message']['from']['id'];
        $message = 'Создан новый тикет №' . $ticket->id . ' от пользователя ' . Auth::user()->email;

        Telegram::sendMessage([
            'chat_id'   => $idLastUserWriteToBot,
            'text'      => $message
        ]);

        return redirect()->route('cabinet.home');
    }

    public function show(Ticket $ticket)
    {
        return view('cabinet.tickets.show', compact('ticket'));
    }

    public function message(MessageRequest $request, Ticket $ticket)
    {
        $user = Auth::user();
        $userId = $user->id;
        $message = $ticket->addMessage($userId, $request['message']);
        $emailRecipient = User::where('id', $ticket->admin_id)->first()->email;

        $ticket->status->setStatusAnswered(false);
        $ticket->status->setStatusSeen(false);

        \Mail::to($emailRecipient)->send(new NewMessage([
            'message'   => $message,
            'ticket'    => $ticket
        ]));

        return redirect()->route('cabinet.tickets.show', ['ticket' => $ticket->id]);
    }

    public function close(Ticket $ticket)
    {
        $ticket->status->setStatusClose();
        $emailRecipient = User::where('id', $ticket->admin_id)->first()->email;

        \Mail::to($emailRecipient)->send(new CloseTicket($ticket));

        \Session::flash('message', 'Тикет №' . $ticket->id . ' закрыт');
        return redirect()->route('cabinet.home');
    }
}
