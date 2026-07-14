@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Transaction Headers</h1>
        <a href="{{ route('transaction.create') }}"><button class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
        </button></a>
    </div>
    <table class="table text-center border-separate border-spacing-y-2">
        <thead class="table-light">
            <tr>
                <th>Invoice</th>
                <th>Date</th>
                <th>Total</th>
                <th>Parent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->invoice }}</td>
                <td>{{ $transaction->date->format('d-m-Y') }}</td>
                <td>{{ number_format($transaction->total, 0,',','.') }}</td>
                <td>{{ $transaction->student->parent->name }}</td>
                <td>
                    <button type="button" class="btn btn-info open-info-modal" data-target="transaction-{{ $transaction->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                    <x-modal.info id="transaction-{{ $transaction->id }}" title="Transaction Detail" :data="[
                        'Student' => $transaction->student->name,
                        'Notes' => $transaction->detail,
                        'Detail' => $transaction->details,
                    ]">
                    </x-modal>
                    <a href="{{ route('transaction.edit', $transaction) }}"><button class="btn btn-info" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                    </button></a>
                    <button type="button" class="btn btn-danger open-delete-modal" data-url="{{ route('transaction.destroy', $transaction) }}"  data-model="Transaction" data-name="{{ $transaction->invoice }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-modal.delete >
</x-modal>

<script>
    $(document).on('click', '.open-info-modal', function () {
        let target = $(this).data('target');
        let modal = $('#' + target);
        let content = modal.find('.modal-content');

        modal.removeClass('hidden').addClass('flex');

        setTimeout(() => {
            modal.removeClass('opacity-0');
            content.removeClass('scale-95 translate-y-4 opacity-0');
            content.addClass('scale-100 translate-y-0 opacity-100');
        }, 10);
    });

    $(document).on('click', '.close-modal, .overlay', function () {
        let modal = $(this).closest('.fixed');
        let content = modal.find('.modal-content');

        content.removeClass('scale-100 translate-y-0 opacity-100');
        content.addClass('scale-95 translate-y-4 opacity-0');

        modal.addClass('opacity-0');

        setTimeout(() => {
            modal.removeClass('flex').addClass('hidden');
        }, 300);
    });

    $(document).on('click', '.overlay', function(){
        let modal = $(this).closest('.fixed');
        let content = modal.find('.modal-content');

        content.removeClass('scale-100 translate-y-0 opacity-100');
        content.addClass('scale-95 translate-y-4 opacity-0');

        modal.addClass('opacity-0');

        setTimeout(() => {
            modal.removeClass('flex').addClass('hidden');
        }, 300);
    });
</script>
@endsection