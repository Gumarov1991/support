@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <span class="alert-primary">{{ Session::get('message') }}</span>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <th nowrap>@sortablelink('id', 'Id')</th>
                <th>@sortablelink('subject', 'Тема')</th>
                <th>@sortablelink('user.email', 'Email')</th>
                <th nowrap>@sortablelink('status.is_closed', 'Закрыто')</th>
                <th nowrap>@sortablelink('status.is_answered', 'Ответили')</th>
                <th nowrap>@sortablelink('status.is_seen', 'Просмотрено')</th>
                <th nowrap>@sortablelink('status.is_taken', 'Принято')</th>
                <th>@sortablelink('updated_at', 'Последнее изменение')</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>
                        {{ $ticket->subject }}
                        <div><a href="{{ route('admin.tickets.show', $ticket) }}">Посмотреть</a></div>
                        @unless($ticket->status->is_closed)
                            <div><a href="{{ route('admin.tickets.close', $ticket) }}">Закрыть</a></div>
                        @endunless
                        @unless($ticket->status->is_taken)
                            <div><a href="{{ route('admin.tickets.take', $ticket) }}">Принять на выполнение</a></div>
                        @endunless
                    </td>
                    <td>{{ $ticket->user->email }}</td>
                    <td>
                        @if ($ticket->status->is_closed)
                            <span class="badge badge-danger">Закрыто</span>
                        @else
                            <span class="badge badge-primary">Открыто</span>
                        @endif
                    </td>
                    <td>
                        @if ($ticket->status->is_answered)
                            <span class="badge badge-primary">Ответили</span>
                        @else
                            <span class="badge badge-danger">Не отвечали</span>
                        @endif
                    </td>
                    <td>
                        @if ($ticket->status->is_seen)
                            <span class="badge badge-primary">Просмотрено</span>
                        @else
                            <span class="badge badge-danger">Не просмотрено</span>
                        @endif
                    </td>
                    <td>
                        @if ($ticket->status->is_taken)
                            <span class="badge badge-primary">Принято</span>
                        @else
                            <span class="badge badge-danger">Не принято</span>
                        @endif
                    </td>
                    <td>{{ $ticket->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $tickets->appends(\Request::except('page'))->render() }}
    </div>
@endsection
