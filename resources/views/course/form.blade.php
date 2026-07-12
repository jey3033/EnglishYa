@extends('layouts.app')

@section('title', 'Course Form')

@section('content')
<div class="container">
    <h1>Course Form</h1>

    @if ($errors->any())
        <div class="alert color-danger my-5" id="alert">
            <button
                type="button"
                onclick="dismissError()"
                class="close-button"
            >
                &times;
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($course) ? route('course.update', $course) : route('course.store') }}" method="POST">
        @csrf
        @if (isset($course))
            @method('PUT')
        @endif
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $course->name ?? old('name') }}" required class="form-input" placeholder="Enter name">
        </div>
        <div>
            <label for="description">description</label>
            <textarea name="description" id="description" required class="form-input" placeholder="Description for the Course">{{ $course->description ?? old('description') }}</textarea>
        </div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="btn btn-primary self-center">Save</button> 
        </div>
    </form>
</div>
@endsection