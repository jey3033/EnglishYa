@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Schedule New Meeting</h1>

    <form action="{{ route('meetings.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" name="time" id="time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lesson_plan" class="form-label">Lesson Plan</label>
            <textarea name="lesson_plan" id="lesson_plan" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="term" class="form-label">Term</label>
            <input type="text" name="term" id="term" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent</label>
            <select name="parent_id" id="parent_id" class="form-select select2" required>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-select select2" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select select2" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success" type="submit">Schedule Meeting</button>
        <a class="btn btn-secondary" href="{{ route('meetings.index') }}">Cancel</a>
    </form>
</div>
@endsection