@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Transaction Headers (Admin)</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice</th>
                <th>Date</th>
                <th>Total</th>
                <th>Parent</th>
                <th>Teacher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->invoice }}</td>
                <td>{{ $transaction->date->format('Y-m-d H:i') }}</td>
                <td>{{ number_format($transaction->total, 2) }}</td>
                <td>{{ $transaction->parent->name }}</td>
                <td>{{ $transaction->teacher->name }}</td>
                <td>
                    <a href="{{ route('transaction-headers.show', $transaction) }}">View</a>
                    <a href="{{ route('transaction-headers.edit', $transaction) }}">Edit</a>
                    <form action="{{ route('transaction-headers.destroy', $transaction) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('transaction-headers.index') }}">Back to My Transactions</a>
</div>
@endsection