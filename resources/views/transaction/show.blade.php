@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Transaction Header Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Invoice: {{ $transactionHeader->invoice }}</h5>
            <p class="card-text"><strong>ID:</strong> {{ $transactionHeader->id }}</p>
            <p class="card-text"><strong>Date:</strong> {{ $transactionHeader->date->format('Y-m-d H:i') }}</p>
            <p class="card-text"><strong>Total:</strong> {{ number_format($transactionHeader->total, 2) }}</p>
            <p class="card-text"><strong>Parent:</strong> {{ $transactionHeader->parent->name }}</p>
            <p class="card-text"><strong>Teacher:</strong> {{ $transactionHeader->teacher->name }}</p>
            <a class="btn btn-primary" href="{{ route('transaction-headers.edit', $transactionHeader) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('transaction-headers.index') }}">Back to List</a>
        </div>
    </div>
</div>
@endsection