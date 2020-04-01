<?

namespace App\Http\Controllers\Admin;

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

class TicketController extends Controller
{
    public function show(Ticket $ticket)
    {
        if (!$ticket->status->isClose()) {
            $ticket->status->setStatusSeen(true);
        }

        return view('admin.tickets.show', compact('ticket'));
    }

    public function message(MessageRequest $request, Ticket $ticket)
    {
        $user = Auth::user();
        $userId = $user->id;
        $message = $ticket->addMessage($userId, $request['message']);
        $emailRecipient = $ticket->user->email;

        $ticket->touch();
        $ticket->status->setStatusAnswered(true);

        \Mail::to($emailRecipient)->send(new NewMessage([
            'message'   => $message,
            'ticket'    => $ticket
        ]));

        return redirect()->route('admin.tickets.show', $ticket);
    }

    public function close(Ticket $ticket)
    {

        $ticket->status->setStatusClose();
        $emailRecipient = $ticket->user->email;

        \Mail::to($emailRecipient)->send(new CloseTicket($ticket));

        \Session::flash('message', 'Тикет №' . $ticket->id . ' закрыт');
        return redirect()->route('admin.home');
    }

    public function take(Ticket $ticket)
    {
        $adminId = Auth::user()->id;
        $ticket->takeByAdmin($adminId);

        return redirect()->route('admin.tickets.show', $ticket);
    }
}
