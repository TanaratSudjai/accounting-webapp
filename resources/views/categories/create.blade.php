@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<h1>Add Category</h1>
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label for="type">Type:</label>
        <input type="text" name="type" required>
    </div>
    <button type="submit">Add Category</button>
</form>
@endsection
