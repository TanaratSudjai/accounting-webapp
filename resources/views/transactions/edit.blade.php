@extends('layouts.app')

@section('title', 'Edit Transaction')

@section('content')
<h1>Edit Transaction</h1>
<form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="amount">Amount:</label>
        <input type="number" name="amount" step="0.01" value="{{ $transaction->amount }}" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea name="description" required>{{ $transaction->description }}</textarea>
    </div>
    <div>
        <label for="transaction_date">Date:</label>
        <input type="date" name="transaction_date" value="{{ $transaction->transaction_date }}" required>
    </div>
    <button type="submit">Update Transaction</button>
</form>
@endsection
