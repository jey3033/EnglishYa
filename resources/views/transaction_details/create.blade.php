@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Transaction Detail</h1>
    <form action="{{ route('transaction-details.store') }}" method="POST">
        @csrf
        <div>
            <label for="transaction_header_id">Transaction Header:</label>
            <select name="transaction_header_id" id="transaction_header_id" required>
                <option value="">Select Header</option>
                @foreach($headers as $header)
                <option value="{{ $header->id }}" {{ $selectedHeader && $selectedHeader->id == $header->id ? 'selected' : '' }}>
                    {{ $header->invoice }} - {{ $header->date->format('Y-m-d') }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="report_id">Report:</label>
            <select name="report_id" id="report_id" required>
                <option value="">Select Report</option>
                @foreach($reports as $report)
                <option value="{{ $report->id }}">
                    {{ $report->meeting_number }} - {{ $report->meeting_date->format('Y-m-d') }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="price_per_hour">Price per Hour:</label>
            <input type="number" step="0.01" name="price_per_hour" id="price_per_hour" required>
        </div>
        <div>
            <label for="hours">Hours:</label>
            <input type="number" name="hours" id="hours" min="1" required>
        </div>
        <div>
            <label for="detail">Detail:</label>
            <textarea name="detail" id="detail" required></textarea>
        </div>
        <button type="submit">Add Detail</button>
    </form>
    <a href="{{ route('transaction-details.index') }}">Back to List</a>
</div>
@endsection