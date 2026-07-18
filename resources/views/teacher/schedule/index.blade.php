@extends('layouts.app')

@section('title', 'Teacher Schedule')

@section('content')
<main class="">
    <x-calendar />
    <x-modal.schedule.detail>
        saaaaa
    </x-modal.schedule.detail>
</main>

<script>
    $(document).ready(function () {
        $(document).on('click', '.open-detail', function() {
            let modal = $('#detail-modal');
            let content = modal.find('.modal-content');
            
            modal.removeClass('hidden').addClass('flex');

            setTimeout(() => {
                modal.removeClass('opacity-0');
                content.removeClass('scale-95 translate-y-4 opacity-0');
                content.addClass('scale-100 translate-y-0 opacity-100');
            }, 10);
        })
    });
</script>
@endsection