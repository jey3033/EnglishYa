@extends('layouts.app')

@section('title', 'Student Enrollment')

@section('content')
<main class="flex flex-col my-5 mx-5">
    <div class="flex justify-center mb-5">
        <a href="{{ route('student.transaction.create') }}"><button class="btn btn-primary w-70 flex justify-around">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
            <div>Enrolling Brooooooo</div>  
        </button></a>
    </div>
    @foreach ($transactions as $transaction)
        <x-card variant="single" title="{{ $transaction->invoice }}" edit=true>
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-4 font-bold text-center">
                    <div>Date</div>
                    <div>Course Name</div>
                    <div>Hours</div>
                    <div>Subtotal</div>
                </div>
                <div class="grid grid-cols-4 text-center">
                    @foreach ($transaction->details as $detail)
                        <div>{{ $transaction->date->format('d-m-Y') }}</div>
                        <div>{{ $detail->course->name }}</div>
                        <div>{{ $detail->hours }}</div>
                        <div>{{ number_format($detail->subtotal, 0,',','.') }}</div>
                    @endforeach
                </div>
            </x-slot>
        </x-card>
    @endforeach
</main>
@endsection