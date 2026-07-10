@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Parent + Child Registration</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parents.register') }}" method="POST">
        @csrf

        <h2>Parent Information</h2>
        <div>
            <label>Parent Name</label>
            <input type="text" name="parent_name" value="{{ old('parent_name') }}" required>
        </div>
        <div>
            <label>Parent Email</label>
            <input type="email" name="parent_email" value="{{ old('parent_email') }}" required>
        </div>
        <div>
            <label>Parent Password</label>
            <input type="password" name="parent_password" required>
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="parent_password_confirmation" required>
        </div>

        <h2>Child Information</h2>
        <div>
            <label>Child Name</label>
            <input type="text" name="child_name" value="{{ old('child_name') }}" required>
        </div>
        <div>
            <label>Child Email</label>
            <input type="email" name="child_email" value="{{ old('child_email') }}" required>
        </div>
        <div>
            <label>Child Password</label>
            <input type="password" name="child_password" required>
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="child_password_confirmation" required>
        </div>

        <button type="submit">Register Parent & Child</button>
    </form>
</div>
@endsection