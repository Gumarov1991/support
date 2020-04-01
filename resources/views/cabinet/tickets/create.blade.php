@extends('layouts.app')

@section('content')
    <div class="container">
        <p><a href="{{ route('cabinet.home') }}" class="btn btn-success">Все тикеты</a></p>
        <form method="POST" action="{{ route('cabinet.tickets.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="subject" class="col-form-label">Тема</label>
                <input id="subject" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject') }}" required>
                @if ($errors->has('subject'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('subject') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="content" class="col-form-label">Сообщение</label>
                <textarea id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" rows="10" required>{{ old('content') }}</textarea>
                @if ($errors->has('content'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="photos" class="col-form-label">Файл</label>
                <input type="file" id="photos" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="photos[]" multiple>
                @if ($errors->has('file'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('file') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
