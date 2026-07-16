@extends('layouts.app')

@section('title', 'User Form')

@section('content')
<div class="container">
    <h1>Children Registration Form</h1>

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
    
    <button id="add-children" class="btn btn-primary flex justify-around">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>
        <div class="ms-5">
            Add Children
        </div>
    </button>
    <form action="{{ route('parent.transaction.store') }}" method="post" id="parent-form">
        @csrf
        <button type="submit" class="btn btn-light fab">Save</button>  
    </form>
</div>

<script>
    $(document).ready(function () {
        function initializeRow(row){
            row.find('.student-select').each(function(){
                new TomSelect(this,{
                    create:false,
                    allowEmptyOption:true
                });
            });

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

        let rowIndex = 0;
        let rowDataIndex = [];

        let children = "";
        @foreach($children as $child)
            children += `<option value = {{ $child->id }}>{{ $child->name }}</option>`;
        @endforeach
        let courses = "";
        @foreach($courses as $course)
            courses += `<option value = {{ $course->id }}>{{ $course->name }}</option>`;
        @endforeach
        let packages = "";
        @foreach($packages as $package)
            packages += `<option value = {{ $package->id }}>{{ $package->name }}</option>`;
        @endforeach
        $('#add-children').click(function (e) { 
            let newDiv = `
            <div class='card child-card mb-5' data-child-index="${rowIndex}">
                <div class='card-title'>
                    <label for="children-${rowIndex}">Student Name</label>
                    <select name="children[${rowIndex}][student_id]" class="student-select" id="children-${rowIndex}">
                        ${children}
                    </select>
                </div>
                <div class='card-body'>
                    <div class="grid grid-cols-4 mt-5">
                        <div class="text-center">
                            <button class="btn btn-light btn-circle add-detail" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="w-6 h-6">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 course-detail" id="course-detail-${rowIndex}">
                        <div class="card bg-primary-light me-5 mt-5">
                            <div>
                                <label for="course-${rowIndex}-0">Course</label>
                                <select name="enroll[${rowIndex}][0][course_id]" class="course-select" id="course-${rowIndex}-0">
                                    ${courses}
                                </select>
                            </div>
                            <div>
                                <label for="package-${rowIndex}-0">Packages</label>
                                <select name="enroll[${rowIndex}][0][package_id]" class="package-select" id="package-${rowIndex}-0">
                                    ${packages}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
            $('#parent-form').append(newDiv);

            let newRow = $('#parent-form .child-card').last();
            initializeRow(newRow)
            rowDataIndex[rowIndex] = 1;
            rowIndex++;
        });

        $(document).on('click', '.add-detail', function () {
            const childCard = $(this).closest('.child-card');
            const childIndex = childCard.data('child-index');
            const detailIndex = rowDataIndex[childIndex];

            const newCard = `
                <div class="detail-card card bg-primary-light me-5 mt-5">
                    <button type="button" class="delete-detail absolute top-3 right-3 text-danger hover:text-danger-hover transition" title="Remove Detail">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div>
                        <label for="course-${childIndex}-${detailIndex}">Course</label>
                        <select
                            name="enroll[${childIndex}][${detailIndex}][course_id]"
                            class="course-select" id="course-${childIndex}-${detailIndex}">
                            ${courses}
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="package-${childIndex}-${detailIndex}">Package</label>
                        <select
                            name="enroll[${childIndex}][${detailIndex}][package_id]"
                            class="package-select" id="package-${childIndex}-${detailIndex}">
                            ${packages}
                        </select>
                    </div>
                </div>
            `;

            $('#course-detail-' + childIndex).append(newCard);

            const newRow = childCard.find('.course-detail .card').last();
            initializeRow(newRow);

            rowDataIndex[childIndex]++;
        });

        $(document).on('click', '.delete-detail', function () {
            $(this).closest('.detail-card').remove();
        });
    });
</script>
@endsection