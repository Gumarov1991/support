@component('mail::message')
# Создан новый тикет

@component('mail::table')
| Тема  | {{ $ticket->subject }}    |
| :---- | :------------------------ |
| Имя   | {{ $ticket->user->name }} |
| Email | {{ $ticket->user->email }}|
@endcomponent

@component('mail::panel')
{{ $ticket->content }}
@endcomponent

@component('mail::button', ['url' => route('cabinet.tickets.show', ['ticket' => $ticket->id])])
Ответить на тикет
@endcomponent

@endcomponent
