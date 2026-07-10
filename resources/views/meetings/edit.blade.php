@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Meeting</h1>

    <form action="{{ route('meetings.update', $meeting) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $meeting->date->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" name="time" id="time" class="form-control" value="{{ $meeting->time }}" required>
        </div>

        <div class="mb-3">
            <label for="lesson_plan" class="form-label">Lesson Plan</label>
            <textarea name="lesson_plan" id="lesson_plan" class="form-control" rows="4" required>{{ $meeting->lesson_plan }}</textarea>
        </div>

        <div class="mb-3">
            <label for="term" class="form-label">Term</label>
            <input type="text" name="term" id="term" class="form-control" value="{{ $meeting->term }}" required>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent</label>
            <select name="parent_id" id="parent_id" class="form-select select2" required>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ $meeting->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-select select2" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ $meeting->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select select2" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $meeting->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success" type="submit">Update Meeting</button>
        <a class="btn btn-secondary" href="{{ route('meetings.show', $meeting) }}">Back to Details</a>
    </form>
</div>
@endsection