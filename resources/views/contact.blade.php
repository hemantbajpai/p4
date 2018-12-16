@extends('layouts.master')

@section('content')
    <h1>Contact</h1>
    <p>
        For more information, please email {{ config('mail.supportEmail') }}.
    </p>
@endsection