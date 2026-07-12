@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Transaction Headers</h1>
        <a class="btn btn-primary" href="{{ route('transaction.create') }}">Create New Transaction</a>
    </div>
    <table class="table text-center border-separate border-spacing-y-2">
        <thead class="table-light">
            <tr>
                <th>Invoice</th>
                <th>Date</th>
                <th>Total</th>
                <th>Parent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->invoice }}</td>
                <td>{{ $transaction->date->format('d-m-Y') }}</td>
                <td>{{ number_format($transaction->total, 2) }}</td>
                <td>{{ $transaction->student->parent->name }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('transaction.show', $transaction) }}">View</a>
                    <a class="btn btn-info" href="{{ route('transaction.edit', $transaction) }}">Edit</a>
                    <button type="button" class="btn btn-danger open-delete-modal" data-url="{{ route('transaction.destroy', $transaction) }}" data-name="Invoice {{ $transaction->invoice }}">Delete</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection