@extends('layouts.master')

@section('title')
    My paste
@endsection

@section('content')
    {{ $paste['text'] }}
@endsection