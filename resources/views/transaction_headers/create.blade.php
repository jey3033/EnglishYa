@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Create Transaction Header</h1>

    <form action="{{ route('transaction-headers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="invoice" class="form-label">Invoice</label>
            <input type="text" name="invoice" id="invoice" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="datetime-local" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent</label>
            <select name="parent_id" id="parent_id" class="form-select select2" required>
                <option value="">Select Parent</option>
                <option value="{{ Auth::id() }}">Me (if parent)</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select select2" required>
                <option value="">Select Teacher</option>
                <option value="1">Teacher 1</option>
            </select>
        </div>

        <button class="btn btn-success" type="submit">Create</button>
        <a class="btn btn-secondary" href="{{ route('transaction-headers.index') }}">Back to List</a>
    </form>
</div>
@endsection