@extends('layouts.app')

@section('content')
    <div class="container">
        <p><a href="{{ route('cabinet.tickets.create') }}" class="btn btn-success">Окрыть тикет</a></p>
        @if (Session::has('error'))
            <span class="alert-danger">{{ Session::get('error') }}</span>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <th>@sortablelink('id', 'Id')</th>
                <th>@sortablelink('subject', 'Тема')</th>
                <th>@sortablelink('status.is_closed', 'Статус')</th>
                <th>@sortablelink('updated_at', 'Последнее изменение')</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->subject }}</td>
                    <td>
                        @if ($ticket->status->is_closed)
                            <span class="badge badge-danger">Закрыто</span>
                        @elseif ($ticket->status->is_answered)
                            <span class="badge badge-info">Поступил ответ</span>
                        @elseif ($ticket->status->is_taken)
                            <span class="badge badge-success">Принят в обработку</span>
                        @else
                            <span class="badge badge-primary">Открыто</span>
                        @endif
                    </td>
                    <td>{{ $ticket->updated_at }}</td>
                    <td>
                        <div><a href="{{ route('cabinet.tickets.show', $ticket) }}">Посмотреть</a></div>
                        @unless($ticket->status->is_closed)
                            <div><a href="{{ route('cabinet.tickets.close', $ticket) }}">Закрыть</a></div>
                        @endunless
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $tickets->appends(\Request::except('page'))->render() }}
    </div>
@endsection
