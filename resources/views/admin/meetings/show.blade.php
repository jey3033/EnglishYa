@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Meeting Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Meeting #{{ $meeting->id }}</h5>
            <p class="card-text"><strong>Date:</strong> {{ $meeting->date->format('Y-m-d') }}</p>
            <p class="card-text"><strong>Time:</strong> {{ $meeting->time }}</p>
            <p class="card-text"><strong>Lesson Plan:</strong> {{ $meeting->lesson_plan }}</p>
            <p class="card-text"><strong>Term:</strong> {{ $meeting->term }}</p>
            <p class="card-text"><strong>Parent:</strong> {{ $meeting->parent->name }}</p>
            <p class="card-text"><strong>Student:</strong> {{ $meeting->student->name }}</p>
            <p class="card-text"><strong>Teacher:</strong> {{ $meeting->teacher->name }}</p>
            <a class="btn btn-secondary" href="{{ route('meetings.index') }}">Back to Meetings</a>
            <a class="btn btn-primary" href="{{ route('meetings.edit', $meeting) }}">Edit</a>
        </div>
    </div>
</div>
@endsection