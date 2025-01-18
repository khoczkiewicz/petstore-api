@extends('layouts.app')

@section('title', 'Edit Pet')
@section('header', 'Edit Pet')

@section('content')
<form method="POST" action="{{ route('pets.update', $pet['id']) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $pet['name'] }}" required>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="available" {{ $pet['status'] === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ $pet['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ $pet['status'] === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection