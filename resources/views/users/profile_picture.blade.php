@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Update Profile Picture</h1>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="image">Profile Image (jpeg|png|jpg|gif|svg)</label>
            <input type="file" name="image" id="image" required>
        </div>

        <button type="submit">Upload</button>
    </form>
</div>
@endsection