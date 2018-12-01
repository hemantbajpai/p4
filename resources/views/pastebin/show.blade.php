@extends('layouts.master')

@section('title')
    My paste
@endsection


@section('content')
    <h1>My paste</h1>
    <p>Expiry Date: {{ $paste['date'] }}</p>
    <p>Text: {{ $paste['text'] }}</p>
@endsection