@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Transaction Details</h1>
        <a class="btn btn-primary" href="{{ route('transaction-details.create') }}">Add New Detail</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Header Invoice</th>
                <th>Report Meeting</th>
                <th>Price/Hour</th>
                <th>Hours</th>
                <th>Subtotal</th>
                <th>Detail</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
            <tr>
                <td>{{ $detail->id }}</td>
                <td>{{ $detail->transactionHeader->invoice }}</td>
                <td>{{ $detail->report->meeting_number }}</td>
                <td>{{ number_format($detail->price_per_hour, 2) }}</td>
                <td>{{ $detail->hours }}</td>
                <td>{{ number_format($detail->subtotal, 2) }}</td>
                <td>{{ $detail->detail }}</td>
                <td>
                    <a href="{{ route('transaction-details.show', $detail) }}">View</a>
                    <a href="{{ route('transaction-details.edit', $detail) }}">Edit</a>
                    <form action="{{ route('transaction-details.destroy', $detail) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection