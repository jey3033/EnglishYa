@extends('layouts.app')

@section('title', 'User Form')

@section('content')
<div class="container">
    <h1>User Form</h1>

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

    <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
        @csrf
        @if (isset($user))
            @method('PUT')
        @endif
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $user->name ?? old('name') }}" required class="form-input" placeholder="Enter name">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email ?? old('email') }}" required class="form-input" placeholder="Enter email">
        </div>
        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="admin" {{ isset($user) && $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teacher" {{ isset($user) &&  $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="parent" {{ isset($user) &&  $user->role === 'parent' ? 'selected' : '' }}>Parent</option>
                <option value="student" {{ isset($user) &&  $user->role === 'student' ? 'selected' : '' }}>Student</option>
            </select>
        </div>
        @if (isset($user) && $user->role === 'student')
            <div>
            <label for="parent_id">Parent</label>
            <select name="parent_id" id="parent_id" required>
                @foreach ($parents as $item)
                    <option value={{ $item->id }} {{ isset($user) && $user->parent_id === $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div>
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ $user->phone_number ?? old('phone_number') }}" required class="form-input" placeholder="Enter phone number">
        </div>
        @if (!isset($user))
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required class="form-input" placeholder="Enter password">
            </div>
            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input" placeholder="Confirm password">
            </div>
        @endif
        @if (isset($user))
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    value="1"
                    @checked(old('is_active', $user->is_active))
                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                >

                <label for="is_active" class="cursor-pointer">
                    Active
                </label>
            </div>
        @endif
        <div class="flex justify-center mt-5">
            <button type="submit" class="btn color-primary self-center">Save</button> 
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const parentSelect = document.createElement('select');

        new TomSelect(roleSelect, {
                create: false,
                controlInput: null,
                placeholder: 'Select a role',
            });
        
    });  
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const parentSelect = document.getElementById('parent_id');

        new TomSelect(parentSelect, {
                plugins: ['dropdown_input'],
                create: false,
                placeholder: 'Select parent',
            });
        
    }); 
</script> 
@endsection