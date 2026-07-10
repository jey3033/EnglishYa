@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Transaction Detail</h1>
    <p><strong>ID:</strong> {{ $transactionDetail->id }}</p>
    <p><strong>Header Invoice:</strong> {{ $transactionDetail->transactionHeader->invoice }}</p>
    <p><strong>Report Meeting:</strong> {{ $transactionDetail->report->meeting_number }}</p>
    <p><strong>Price per Hour:</strong> {{ number_format($transactionDetail->price_per_hour, 2) }}</p>
    <p><strong>Hours:</strong> {{ $transactionDetail->hours }}</p>
    <p><strong>Subtotal:</strong> {{ number_format($transactionDetail->subtotal, 2) }}</p>
    <p><strong>Detail:</strong> {{ $transactionDetail->detail }}</p>
    <a href="{{ route('transaction-details.edit', $transactionDetail) }}">Edit</a>
    <a href="{{ route('transaction-details.index') }}">Back to List</a>
</div>
@endsection