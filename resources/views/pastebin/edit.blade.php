@extends('layouts.master')

@section('title')
    Edit paste
@endsection

@section('content')

    <h1>Edit paste</h1>

    <form method='POST' action='/pastebin/{{ $paste->id }}'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='text'>* Text</label>
        <input type='text' name='text' id='text' value='{{ $paste->text }}'>

        <input type='submit' value='Save' class='btn btn-primary'>
    </form>

    @if(count($errors) > 0)
        <div class='alert alert-danger'>
            Please correct the errors above.
        </div>
    @endif
@endsection