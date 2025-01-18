@extends('layouts.app')

@section('title', 'Add Pet')
@section('header', 'Add New Pet')

@section('content')
<form method="POST" action="{{ route('pets.store') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection