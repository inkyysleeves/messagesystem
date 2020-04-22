@extends('layouts.app')
@section('content')
{{ Form::open(['action' => 'MessagesController@store', 'method' => 'POST'  ])}}
@csrf
<div class="form-group">
    <label for="to">To</label>
    <select class="form-control" name="to" id="to">
        @foreach( $users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}, {{ $user->email }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    {{ Form::label('subject', 'Subject')}}
    {{ Form::text('subject', '', ['class' => 'form-control', 'placeholder' => 'Enter Subject'])}}
</div>
<div class="form-group">
    {{ Form::label('message', 'Message')}}
    <textarea class="form-control" name="message" id="message"  rows="3" placeholder="Enter Message"></textarea>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
{{ Form::close()}}

@endsection