@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="parent" {{ $user->role === 'parent' ? 'selected' : '' }}>Parent</option>
                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
            </select>
        </div>

        <div>
            <label for="is_active">Active</label>
            <select name="is_active" id="is_active" required>
                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div>
            <label for="password">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <button type="submit">Update</button>
    </form>
</div>
@endsection