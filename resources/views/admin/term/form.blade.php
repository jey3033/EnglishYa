@extends('layouts.app')

@section('title', 'Package Form')

@section('content')
<div class="container">
    <h1>Package Form</h1>

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

    <form action="{{ isset($term) ? route('term.update', $term) : route('term.store') }}" method="POST">
        @csrf
        @if (isset($term))
            @method('PUT')
        @endif
        <div class='info-div'>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $term->name ?? old('name') }}" required class="form-input" placeholder="Enter name">
        </div>
        <div class='info-div'>
            <label for="meeting_number">Meeting Number</label>
            <input type="text" name="meeting_number" id="meeting_number" value="{{ $term->meeting_number ?? old('meeting_number') }}" required class="form-input" placeholder="Enter name">
        </div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="btn btn-primary self-center">Save</button> 
        </div>
    </form>
</div>
@endsection