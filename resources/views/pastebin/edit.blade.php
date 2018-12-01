@extends('layouts.master')

@section('title')
    Edit paste
@endsection

@section('content')
    @if(count($errors) > 0)
        <div class='alert'>
            Please correct the errors below.
        </div>
    @endif

    <h1>Edit paste</h1>

    <form method='POST' action='/pastebin/{{ $paste->id }}'>
        <div class='details'>* Required fields</div>
        {{ method_field('put') }}
        {{ csrf_field() }}

        <label for='date'>* Expiry Date</label>
        <input type='date' name='date' id='date' value='{{ old('date', $paste->date) }}'>
        @include('modules.field-error', ['field' => 'date'])

        <label for='text'>* Text</label>
        <input type='text' name='text' id='text' value='{{ old('text', $paste->text) }}'>
        @include('modules.field-error', ['field' => 'text'])

        <input type='submit' value='Save' class='btn btn-primary'>
    </form>
@endsection