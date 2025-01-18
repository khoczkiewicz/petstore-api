@extends('layouts.app')

@section('title', 'Pet List')
@section('header', 'Pet List')

@section('content')
<form method="GET" action="{{ route('pets.index') }}" class="mb-4">
    <div class="input-group">
        <select name="status" class="form-select">
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </div>
</form>

<div class="mb-3">
    <a href="{{ route('pets.create') }}" class="btn btn-success">Add New Pet</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pets as $pet)
        <tr>
            <td>{{ $pet['id'] ?? 'N/A' }}</td>
            <td>{{ $pet['name'] ?? 'Unnamed' }}</td>
            <td>{{ $pet['status'] ?? 'Unknown' }}</td>
            <td>
                <a href="{{ route('pets.show', $pet['id']) }}" class="btn btn-info btn-sm">Show</a>
                <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No pets to display</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection