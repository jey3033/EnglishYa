@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Transaction Headers</h1>
        <a class="btn btn-primary" href="{{ route('transaction-headers.create') }}">Create New Transaction</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-light">
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
                    <a class="btn btn-sm btn-info" href="{{ route('transaction-headers.show', $transaction) }}">View</a>
                    <a class="btn btn-sm btn-secondary" href="{{ route('transaction-headers.edit', $transaction) }}">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger open-delete-modal" data-url="{{ route('transaction-headers.destroy', $transaction) }}" data-name="Invoice {{ $transaction->invoice }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection