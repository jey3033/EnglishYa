@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Transaction Header</h1>
    <form action="{{ route('transaction-headers.update', $transactionHeader) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="invoice" class="form-label">Invoice</label>
            <input type="text" name="invoice" id="invoice" class="form-control" value="{{ $transactionHeader->invoice }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="datetime-local" name="date" id="date" class="form-control" value="{{ $transactionHeader->date->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ $transactionHeader->total }}" required>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent</label>
            <select name="parent_id" id="parent_id" class="form-select select2" required>
                <option value="{{ $transactionHeader->parent_id }}">{{ $transactionHeader->parent->name }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select select2" required>
                <option value="{{ $transactionHeader->teacher_id }}">{{ $transactionHeader->teacher->name }}</option>
            </select>
        </div>

        <button class="btn btn-success" type="submit">Update</button>
        <a class="btn btn-secondary" href="{{ route('transaction-headers.show', $transactionHeader) }}">Cancel</a>
        <a class="btn btn-light" href="{{ route('transaction-headers.index') }}">Back to List</a>
    </form>
</div>
@endsection