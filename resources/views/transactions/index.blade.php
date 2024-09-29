@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<h1>Transactions</h1>
<a href="{{ route('transactions.create') }}">Add New Transaction</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->description }}</td>
            <td>{{ $transaction->transaction_date }}</td>
            <td>
                <a href="{{ route('transactions.edit', $transaction->id) }}">Edit</a>
                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
