@component('mail::message')
# Тикет №{{ $ticket->id }} закрыт @if (\Illuminate\Support\Facades\Auth::user()->isAdmin())
администратором
@else
пользователем {{ $ticket->user->email }}
@endif

@if (\Illuminate\Support\Facades\Auth::user()->isAdmin())
@component('mail::button', ['url' => route('cabinet.tickets.show', ['ticket' => $ticket->id])])
@else
@component('mail::button', ['url' => route('admin.tickets.show', ['ticket' => $ticket->id])])
@endif
Посмотреть тикет
@endcomponent

@endcomponent
