@extends('layouts.master')

@section('title')
    My pastes
@endsection

@section('content')
    <table class="table table-striped">
        <tr>
            <th>Expiry Date</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        @foreach($pastes as $paste)
            <tr>
                <td>
                    {{ $paste['date'] }}
                </td>
                <td>
                    <a href='/pastebin/{{ $paste['id'] }}'><i class="fas fa-eye"></i></a>
                </td>
                <td>
                    <a href='/pastebin/{{ $paste['id'] }}/edit'><i class="fas fa-pencil-alt"></i></a>
                </td>
                <td>
                    <a href='/pastebin/delete/{{ $paste['id'] }}'><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection