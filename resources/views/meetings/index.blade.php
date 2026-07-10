@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Meetings</h1>
        <a class="btn btn-primary" href="{{ route('meetings.create') }}">Schedule New Meeting</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Term</th>
                <th>Parent</th>
                <th>Student</th>
                <th>Teacher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->id }}</td>
                    <td>{{ $meeting->date->format('Y-m-d') }}</td>
                    <td>{{ $meeting->time }}</td>
                    <td>{{ $meeting->term }}</td>
                    <td>{{ $meeting->parent->name }}</td>
                    <td>{{ $meeting->student->name }}</td>
                    <td>{{ $meeting->teacher->name }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('meetings.show', $meeting) }}">View</a>
                        <a class="btn btn-sm btn-secondary" href="{{ route('meetings.edit', $meeting) }}">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger open-delete-modal" data-url="{{ route('meetings.destroy', $meeting) }}" data-name="Meeting #{{ $meeting->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection