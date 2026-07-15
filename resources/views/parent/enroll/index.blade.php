@extends('layouts.app')

@section('title', 'Parent Dashboard')

@section('content')
<main class="flex flex-col my-5 mx-5">
    <div class="flex justify-center mb-5">
        <a href="{{ route('parent.transaction.create') }}"><button class="btn btn-primary w-70 flex justify-around">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
            <div>I want to Enroll My Children  </div>  
        </button></a>
    </div>
    @foreach ($children as $child)
        <x-card variant="single" title="{{ $child->name }}" edit=true>
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-5 font-bold text-center">
                    <div>Invoice</div>
                    <div>Date</div>
                    <div>Course Name</div>
                    <div>Hours</div>
                    <div>Subtotal</div>
                </div>
                <div class="grid grid-cols-5 text-center">
                @foreach ($child->transactions as $transaction)
                    @foreach ($transaction->details as $detail)
                        <div>{{ $transaction->invoice }}</div>
                        <div>{{ $transaction->date->format('d-m-Y') }}</div>
                        <div>{{ $detail->course->name }}</div>
                        <div>{{ $detail->hours }}</div>
                        <div>{{ number_format($detail->subtotal, 0,',','.') }}</div>
                    @endforeach
                @endforeach
                </div>
            </x-slot>
        </x-card>
    @endforeach
</main>
@endsection