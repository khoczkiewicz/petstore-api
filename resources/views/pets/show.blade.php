@extends('layouts.app')

@section('title', 'Pet Details')
@section('header', 'Pet Details')

@section('content')
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $pet['id'] }}</td>
    </tr>
    <tr>
        <th>Name</th>
        <td>{{ $pet['name'] }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ $pet['status'] }}</td>
    </tr>
</table>
<a href="{{ route('pets.index') }}" class="btn btn-secondary">Back to List</a>
@endsection