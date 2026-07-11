@extends('layouts.app')

@section('title', 'User Change Password Form')

@section('content')
<div class="container">
    <h1>User Change Password</h1>

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

    <form action="{{ route('users.updatepassword', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name : {{ old('name', $user->name) }}</label>
        </div>

        <div>
            <label for="email">Email : {{ old('email', $user->email) }}</label>
        </div>

        <div>
            <label for="role">Role : {{ old('role',$user->role) }}</label>
        </div>

        <div>
            <label for="is_active">Active : {{ $user->is_active ? 'Yes' : 'No' }}</label>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-input">
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
        </div>
        <div class="flex justify-center mt-3">
            <button type="submit" class="btn color-primary">Update</button>
        </div>
    </form>
</div>
@endsection