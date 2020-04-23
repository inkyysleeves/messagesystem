@extends('layouts.app')
@section('content')
    @if (count($messages) > 0)
    <ul class="list-group">
        @foreach($messages as $message)
        <li class="list-group-item"><strong>To: {{ $message->userTo->name}}, {{ $message->userTo->email}}</strong> | Subject: {{ $message->subject }}
        @if($message->read)
        <span class="badge badge-success float-right">READ</span>
        @endif
        </li>
        @endforeach

    </ul>
    @else
    no messages!
    @endif


@endsection