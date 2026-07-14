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

    <form action="{{ isset($student) ? route('student.update', $student) : route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($student))
            @method('PUT')
        @endif
        <div class="info-div flex justify-center">
            <img
                src="{{ isset($studentData) && $studentData->profile_path ? asset('storage/' . $studentData->profile_path) : "https://api.dicebear.com/9.x/personas/svg?seed=$student->name" }}"
                alt="Profile Picture"
                class="profile-picture"
            />
        </div>
        <div class="info-div">
            <label for="name">Name: {{ $student->name }}</label>
        </div>
        <div class="info-div">
            <label for="email">Email: {{ $student->email }}</label>
        </div>
        <div class="info-div">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/*" class="form-input">
        </div>
        <div class="info-div">
            <label for="preferred_language">Preferred Language</label>
            <select name="preferred_language" id="preferred_language" class="form-select">
                <option value="English" {{ isset($studentData) && $studentData->preferred_language === 'English' ? 'selected' : '' }}>English</option>
                <option value="Indonesian" {{ isset($studentData) && $studentData->preferred_language === 'Indonesian' ? 'selected' : '' }}>Bahasa Indonesia</option>
                <option value="Mandarin" {{ isset($studentData) && $studentData->preferred_language === 'Mandarin' ? 'selected' : '' }}>Chinese (Mandarin)</option>
                <option value="Russian" {{ isset($studentData) && $studentData->preferred_language === 'Russian' ? 'selected' : '' }}>Russian</option>
                <option value="Japanese" {{ isset($studentData) && $studentData->preferred_language === 'Japanese' ? 'selected' : '' }}>Japanese</option>
                <option value="Korean" {{ isset($studentData) && $studentData->preferred_language === 'Korean' ? 'selected' : '' }}>Korean</option>
                <option value="French" {{ isset($studentData) && $studentData->preferred_language === 'French' ? 'selected' : '' }}>French</option>
                <option value="German" {{ isset($studentData) && $studentData->preferred_language === 'German' ? 'selected' : '' }}>German</option>
                <option value="Spanish" {{ isset($studentData) && $studentData->preferred_language === 'Spanish' ? 'selected' : '' }}>Spanish</option>
                <option value="Arabic" {{ isset($studentData) && $studentData->preferred_language === 'Arabic' ? 'selected' : '' }}>Arabic</option>
            </select>
        </div>
        <div class="info-div">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" cols="30" rows="10" class="form-input">{{ $studentData->notes ?? old('notes') }}</textarea>
        </div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="btn bg-primary self-center">Save</button> 
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('preferred_language');

        new TomSelect(roleSelect, {
            plugins: ['dropdown_input'],
            create: false,
            placeholder: 'Select Student Preferred Language',
        });
    })
</script> 
@endsection