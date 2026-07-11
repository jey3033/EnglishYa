@extends('layouts.app')

@section('title', 'User Form')

@section('content')
<div class="container">
    <h1>Children Registration Form</h1>

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

    <form action="{{ isset($child) ? route('parent.child.update', $child) : route('parent.child.store') }}" method="POST">
        @csrf
        @if (isset($child))
            @method('PUT')
        @endif
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $child->name ?? old('name') }}" required class="form-input" placeholder="Enter name">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $child->email ?? old('email') }}" required class="form-input" placeholder="Enter email">
        </div>
        <div>
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ $child->phone_number ?? old('phone_number') }}" required class="form-input" placeholder="Enter phone number">
        </div>
        @if (!isset($child))
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required class="form-input" placeholder="Enter password">
            </div>
            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input" placeholder="Confirm password">
            </div>
        @endif
        <div class="flex justify-center mt-5">
            <button type="submit" class="btn color-primary self-center">Save</button> 
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        if($('#role').val() == "student"){
            $('#parent_id-container').show();
        }else{
            $('#parent_id-container').hide();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const parentSelect = document.createElement('select');

        new TomSelect(roleSelect, {
            create: false,
            controlInput: null,
            placeholder: 'Select a role',
        });
        
        $('#role').change(function (e) { 
            if($(this).val() == "student"){
                $('#parent_id-container').show();
            }else{
                $('#parent_id-container').hide();
            }
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