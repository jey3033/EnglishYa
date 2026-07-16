@extends('layouts.app')

@section('title', 'User Form')

@section('content')
<div class="container">
    <h1>Registration Form</h1>

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
    
    <button id="add-detail" class="btn btn-primary flex justify-around">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>
        <div class="ms-5">
            Add Form
        </div>
    </button>
    <form action="{{ route('student.transaction.store') }}" method="post" id="parent-form">
        @csrf
        <div class="grid grid-cols-4 course-detail" id="course-detail">
            <div class="card bg-primary-light me-5 mt-5">
                <div>
                    <label for="course-0">Course</label>
                    <select name="enroll[0][course_id]" class="course-select" id="course-0">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="package-0">Packages</label>
                    <select name="enroll[0][package_id]" class="package-select" id="package-0">
                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-light fab">Save</button>  
    </form>
</div>

<script>
    $(document).ready(function () {
        function initializeRow(row){
            row.find('.course-select').each(function(){
                new TomSelect(this,{
                    create:false,
                    allowEmptyOption:true
                });
            });

            row.find('.package-select').each(function(){
                new TomSelect(this,{
                    create:false,
                    allowEmptyOption:true
                });
            });
        }

        let rowIndex = 1;

        let courses = "";
        @foreach($courses as $course)
            courses += `<option value = {{ $course->id }}>{{ $course->name }}</option>`;
        @endforeach
        let packages = "";
        @foreach($packages as $package)
            packages += `<option value = {{ $package->id }}>{{ $package->name }}</option>`;
        @endforeach

        const newRow = $('#course-detail').find('.card').last();
        initializeRow(newRow);

        $(document).on('click', '#add-detail', function () {
            const newCard = `
                <div class="detail-card card bg-primary-light me-5 mt-5">
                    <button type="button" class="delete-detail absolute top-3 right-3 text-danger hover:text-danger-hover transition" title="Remove Detail">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div>
                        <label for="course-${rowIndex}">Course</label>
                        <select
                            name="enroll[${rowIndex}][course_id]"
                            class="course-select" id="course-${rowIndex}">
                            ${courses}
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="package-${rowIndex}">Package</label>
                        <select
                            name="enroll[${rowIndex}][package_id]"
                            class="package-select" id="package-${rowIndex}">
                            ${packages}
                        </select>
                    </div>
                </div>
            `;

            $('#course-detail').append(newCard);

            const newRow = $('#course-detail').find('.card').last();
            initializeRow(newRow);

            rowIndex++;
        });

        $(document).on('click', '.delete-detail', function () {
            $(this).closest('.detail-card').remove();
        });
    });
</script>
@endsection