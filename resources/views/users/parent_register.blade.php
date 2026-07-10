@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Register Child Account</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parents.register.children') }}" method="POST">
        @csrf

        <div>
            <label for="child_name">Child Name</label>
            <input type="text" name="child_name" id="child_name" value="{{ old('child_name') }}" required>
        </div>

        <div>
            <label for="child_email">Child Email</label>
            <input type="email" name="child_email" id="child_email" value="{{ old('child_email') }}" required>
        </div>

        <div>
            <label for="child_password">Child Password</label>
            <input type="password" name="child_password" id="child_password" required>
        </div>

        <div>
            <label for="child_password_confirmation">Confirm Password</label>
            <input type="password" name="child_password_confirmation" id="child_password_confirmation" required>
        </div>

        <button type="submit">Register Child</button>
    </form>
</div>
@endsection