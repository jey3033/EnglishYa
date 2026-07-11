@extends('layouts.app')

@section('title', 'Package Form')

@section('content')
<div class="container">
    <h1>Package Form</h1>

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

    <form action="{{ isset($term) ? route('term.update', $term) : route('term.store') }}" method="POST">
        @csrf
        @if (isset($term))
            @method('PUT')
        @endif
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $term->name ?? old('name') }}" required class="form-input" placeholder="Enter name">
        </div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="btn color-primary self-center">Save</button> 
        </div>
    </form>
</div>
@endsection