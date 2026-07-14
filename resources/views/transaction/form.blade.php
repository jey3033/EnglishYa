@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Enrollment Form</h1>

    @if ($errors->any())
        <div class="alert bg-danger my-5" id="alert">
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

    <form 
    action="{{ isset($transaction) ? route('transaction.update', $transaction) : route('transaction.store') }}" method="POST">
        @csrf
        @if(isset($transaction))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="invoice">Invoice </label>
            <input type="text" name="invoice" id="invoice" class="form-input" value="{{ $transaction->invoice ?? old('invoice') }}" required>
        </div>

        <div class="mb-3">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-input" value="{{ $transaction->date->format('Y-m-d') ?? old('date') }}" required>
        </div>

        <div class="mb-3">
            <label for="total">Total</label>
            <input name="total" id="total" class="form-input autonumeric" value="{{ $transaction->total ?? old('total') }}" required readonly value="0">
        </div>

        <div class="mb-3">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-select select2" required>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ isset($transaction) && $transaction->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="transaction_status">Transaction Status</label>
            <select name="transaction_status" id="transaction_status" class="form-select select2" required>
                <option value="pending - admin" {{ isset($transaction) && $transaction->transaction_status == "pending - admin" ? 'selected' : '' }}>Pending - Admin</option>
                <option value="pending" {{ isset($transaction) && $transaction->transaction_status == "pending" ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ isset($transaction) && $transaction->transaction_status == "paid" ? 'selected' : '' }}>Paid</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="detail">Detail</label>
            <textarea name="detail" id="detail" cols="30" rows="10" class="form-input">{{ $transaction->detail ?? old('detail') }}</textarea>
        </div>

        {{-- <div class="mb-3">
            <label for="teacher_id">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select select2" required>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div> --}}

        <div class="card-header flex justify-between">
            <h2 class="card-title">Course Detail</h2>

            <button 
                type="button"
                id="add-row"
                class="btn btn-primary">
                Add Row
            </button>
        </div>

        <div class="grid grid-cols-5 gap-4 font-semibold">
            <div>Course</div>
            <div>Package</div>
            <div>Price / Hour</div>
            <div>Subtotal</div>
            <div>Action</div>
        </div>

        <div id="detail-container">
            @if (isset($transaction))
                @foreach ($transaction->details as $detail)
                    <div class="detail-row grid grid-cols-5 gap-4 items-center mt-3">
                        <select name="details[{{ $loop->index }}][course_id]" class="course-select">
                            @foreach ($courses as $course)
                                <option value = {{ $course->id }} {{ $detail->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        <select name="details[{{ $loop->index }}][term_id]" class="package-select">
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}" data-hour="{{ $term->meeting_number }}" {{ $detail->term_id == $term->id ? 'selected' : '' }}>{{ $term->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="details[{{ $loop->index }}][price_per_hour]" value="{{ $detail->price_per_hour }}" class="form-input autonumeric price">
                        <input type="text" name="details[{{ $loop->index }}][subtotal]" value="{{ $detail->subtotal }}" class="form-input subtotal" readonly>
                        <button type="button" class="btn btn-danger delete-row">
                            Delete
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
        
        <div class="flex justify-center mt-5 mb-10">
            <button class="btn btn-primary self-center" type="submit">
                {{ isset($transaction) ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        // const teacherSelect = new TomSelect('#teacher_id', {
        //     create: false,
        //     allowEmptyOption: true,
        //     placeholder: 'Select teacher',
        // });

        const studentSelect = new TomSelect('#student_id', {
            create: false,
            allowEmptyOption: true,
            placeholder: 'Select student',
        });

        const transactionSelect = new TomSelect('#transaction_status', {
            create: false,
            allowEmptyOption: true,
        });

        // teacherSelect.clear();
        @if (!isset($transaction))
            studentSelect.clear();
        @endif

        function initializeRow(row){

            new TomSelect(row.find('.course-select')[0], {
                create:false,
                placeholder:'Select Course',
                allowEmptyOption:true
            });

            new TomSelect(row.find('.package-select')[0], {
                create:false,
                placeholder:'Select Package',
                allowEmptyOption:true
            });

            new AutoNumeric(row.find('.price')[0], {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                decimalPlaces: 0
            });

            calculateSubtotal(row);
        }

        $('#detail-container .detail-row').each(function () {
            initializeRow($(this));
        });

        let rowIndex = $('#detail-container .detail-row').length;
        let courses = "";
        @foreach($courses as $course)
            courses += `<option value = {{ $course->id }}>{{ $course->name }}</option>`;
        @endforeach

        let packages = "";
        @foreach($terms as $term)
            packages += `<option value="{{ $term->id }}" data-hour="{{ $term->meeting_number }}">{{ $term->name }}</option>`;
        @endforeach

        $('#add-row').click(function (e) { 
            let row = `
            <div class="detail-row grid grid-cols-5 gap-4 items-center mt-3">
                <select name="details[${rowIndex}][course_id]" class="course-select">
                    ${courses}
                </select>
                <select name="details[${rowIndex}][term_id]" class="package-select">
                    ${packages}
                </select>
                <input type="text" name="details[${rowIndex}][price_per_hour]" class="form-input autonumeric price">
                <input type="text" name="details[${rowIndex}][subtotal]" class="form-input subtotal" readonly>
                <button type="button" class="btn btn-danger delete-row">
                    Delete
                </button>
            </div>`;
            $('#detail-container').append(row);

            let newRow = $('#detail-container .detail-row').last();
            initializeRow(newRow)
            rowIndex++;
        });

        $(document).on('input', '.price', function(){
            let row = $(this).closest('.detail-row');
            calculateSubtotal(row);
        });

        $(document).on('change', '.package-select', function(){
            let row = $(this).closest('.detail-row');
            calculateSubtotal(row);
        });


        function calculateSubtotal(row){
            let price = AutoNumeric.getAutoNumericElement(row.find('.price')[0]).getNumber();
            let meeting = row.find('.package-select option:selected').data('hour');
            let subtotal = price * meeting;
            row.find('.subtotal').val(new Intl.NumberFormat('id-ID').format(subtotal));
            calculateTotal();
        }

        $(document).on('click','.delete-row',function(){
            $(this).closest('.detail-row').remove();

            calculateTotal();
        });

        function calculateTotal() {
            let total = 0;
            $('.detail-row').each(function () {
                let subtotal = $(this).find('.subtotal').val().replace(/\./g, '');
                total += Number(subtotal) || 0;
            });
            AutoNumeric.getAutoNumericElement($('#total')[0]).set(total);
        }
    });
</script>
@endsection