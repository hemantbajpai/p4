@extends('layouts.master')

@section('title')
    Confirm deletion: {{ $paste->title }}
@endsection

@section('content')
    <h1>Confirm deletion</h1>

    <p>Are you sure you want to delete <strong>{{ $paste->title }}</strong>?</p>

    <form method='POST' action='/pastebin/{{ $paste->id }}'>
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input type='submit' value='Yes, delete it!' class='btn btn-danger btn-small'>
    </form>

    <p class='cancel'>
        <a href='/pastebin/{{ $paste->id }}'>No, I changed my mind.</a>
    </p>

@endsection