@extends('layouts.master')

@section('title')
    Create paste
@endsection

@section('content')

    <h1>Create paste</h1>

    <form method='POST' action='/pastebin'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='text'>* Text</label>
        <input type='text' name='text' id='text' value='{{ old('text') }}'>

        <input type='submit' value='Add' class='btn btn-primary'>
    </form>

    @if(count($errors) > 0)
        <div class='alert alert-danger'>
            Please correct the errors above.
        </div>
    @endif
@endsection