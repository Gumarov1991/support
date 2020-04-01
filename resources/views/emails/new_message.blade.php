@component('mail::message')
# Новое сообщение в тикете №{{ $ticket->id }} от @if (\Illuminate\Support\Facades\Auth::user()->isAdmin())администратора@else{{ $message->user->email }}@endif

@component('mail::panel')
{{ $message->message }}
@endcomponent

@if (\Illuminate\Support\Facades\Auth::user()->isAdmin())
@component('mail::button', ['url' => route('cabinet.tickets.show', ['ticket' => $ticket->id])])
@else
@component('mail::button', ['url' => route('admin.tickets.show', ['ticket' => $ticket->id])])
@endif
Ответить на сообщение
@endcomponent

@endcomponent
