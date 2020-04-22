@extends('layouts.app')
@section('content')
    From: {{ $message->userFrom->name }}
    <br>
    Email: {{ $message->userFrom->email }}
    <br>
    Subject: {{ $message->subject }}
    <hr>
    Message:
    <br>
     {{ $message->body}}
@endsection