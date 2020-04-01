@extends('layouts.app')

@section('content')
<div class="container">
    <p><a href="{{ route('admin.home') }}" class="btn btn-success">Все тикеты</a></p>
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-3">
                <div class="card-header">
                    {{ $ticket->subject }}
                </div>
                <div class="card-body">
                    {!! nl2br(e($ticket->content)) !!}
                    <div class="row">
                        @foreach ($ticket->photos()->get() as $photo)
                            <div class="col-6">
                                <img src="{{ asset('storage/' . $photo->file) }}" >
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @foreach ($ticket->messages()->orderBy('id')->with('user')->get() as $message)
                <div class="card mb-3">
                    <div class="card-header">
                        {{ $message->created_at }} от {{ $message->user->name }}
                    </div>
                    <div class="card-body">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
            @endforeach
            @unless ($ticket->status->is_closed)
                <form method="POST" action="{{ route('admin.tickets.message', $ticket) }}">
                    @csrf

                    <div class="form-group">
                        <textarea class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" rows="3" required>{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('message') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                    </div>
                </form>
            @endunless
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $ticket->id }}</td>
                <tr>
                    <th>Email</th>
                    <td>{{ $ticket->user->email }}</td>
                </tr>
                <tr>
                    <th>Создано</th>
                    <td>{{ $ticket->created_at }}</td>
                </tr>
                <tr>
                    <th>Статус</th>
                    <td>
                        @if ($ticket->status->is_closed)
                            <span class="badge badge-danger">Закрыто</span>
                        @elseif ($ticket->status->is_taken)
                            <span class="badge badge-success">Принят в обработку</span>
                        @else
                            <span class="badge badge-primary">Открыто</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            @unless ($ticket->status->is_taken)
                <div><a href="{{ route('admin.tickets.take', $ticket) }}">Принять в обработку</a></div>
            @endunless
            @unless ($ticket->status->is_closed)
                <div><a href="{{ route('admin.tickets.close', $ticket) }}">Закрыть</a></div>
            @endunless

        </div>
    </div>
</div>
@endsection
