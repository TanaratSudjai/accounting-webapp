@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ $category->name }}" required>
        </div>
        <div>
            <label for="type">Type:</label>
            <input type="text" name="type" value="{{ $category->type }}" required>
        </div>
        <button type="submit">Update Category</button>
    </form>
@endsection
