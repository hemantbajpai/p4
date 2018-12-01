@extends('layouts.master')

@section('title')
    Create paste
@endsection

@section('content')
    @if(count($errors) > 0)
        <div class='alert'>
            Please correct the errors below.
        </div>
    @endif

    <h1>New paste</h1>

    <form method='POST' action='/pastebin'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='date'>* Expiry Date</label>
        <input type='date' name='date' id='date' value='{{ old('date') }}'>
        @include('modules.field-error', ['field' => 'date'])

        <label for='text'>* Text</label>
        <input type='text' name='text' id='text' value='{{ old('text') }}'>
        @include('modules.field-error', ['field' => 'text'])

        <input type='submit' value='Add' class='btn btn-primary'>
    </form>

@endsection