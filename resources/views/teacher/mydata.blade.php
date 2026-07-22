@extends('layouts.app')

@section('title', 'User Form')

@section('content')
<div class="container">
    <h1>User Form</h1>

    @if ($errors->any())
        <div class="alert danger my-5" id="alert">
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

    <form action="{{ route('teacher.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="info-div flex justify-center">
            <x-avatar size="xl" :user="Auth::User()" />
        </div>
        <div class="info-div">
            <label for="name">Name: {{ Auth::user()->name }}</label>
        </div>
        <div class="info-div">
            <label for="email">Email: {{ Auth::user()->email }}</label>
        </div>
        <div class="info-div">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/*" class="form-input">
        </div>
        <div class="info-div flex items-center">
            <label for="color" class="me-5">Calendar Color</label>
            <input type="color" id="color" name="color" value="{{ old('color', Auth::user()->color ?? '#7469B6') }}" class="h-12 w-24 cursor-pointer border rounded">
        </div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="btn bg-primary self-center">Save</button> 
        </div>
    </form>
</div>
@endsection