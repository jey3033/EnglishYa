@extends('layouts.app')

@section('title', 'Teacher Schedule')

@section('content')
<main class="">
    <x-calendar />
    <x-modal.schedule.detail>
        No Details
    </x-modal.schedule.detail>
    <x-modal.schedule.confirmation />
</main>

<script>
    $(document).ready(function () {
        let selectedDate = '';
        let selectedStart = '';
        let selectedEnd = '';

        function loadMeetingTable(date) {
            $.ajax({
                url: '/meetings/date/' + date,
                type: 'GET',
                dataType: 'json',

                success: function(meetings) {
                    console.log(meetings);
                    let html = '';
                    for(let hour = 6; hour < 22; hour++){
                        let start = String(hour).padStart(2,'0') + ':00';
                        let end = String(hour + 1).padStart(2,'0') + ':00';
                        let detail = '-';
                        meetings.forEach(function(meeting){
                            if(meeting.start.substring(0,5) == start){
                                detail = `
                                    <div>
                                        <strong>${meeting.status}</strong><br>
                                        ${meeting.notes ?? ''}
                                    </div>
                                `;
                            }
                        });

                        html += `
                            <tr class="hoverable" data-date="${date}" data-start="${start}" data-end="${end}">
                                <td class="border p-2">${start} - ${end}</td>
                                <td class="border p-2">${detail}</td>
                            </tr>
                        `;
                    }
                    $('#meeting-table-body').html(html);
                },

                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function openAvailabilityModal(date,start,end){
            selectedDate = date;
            selectedStart = start;
            selectedEnd = end;
            $('#modal-date').text(date);
            $('#modal-time').text(start + ' - ' + end);
            $('#confirmation-modal').removeClass('hidden').addClass('flex');

            setTimeout(() => {
                $('#confirmation-modal').removeClass('opacity-0');
                $('#confirmation-modal').find('.modal-content').removeClass('scale-95 translate-y-4 opacity-0');
                $('#confirmation-modal').find('.modal-content').addClass('scale-100 translate-y-0 opacity-100');
            }, 10);
        }

        $(document).on('click','.hoverable',function(){
            let date = $(this).data('date');
            let start = $(this).data('start');
            let end = $(this).data('end');
            openAvailabilityModal(date,start,end);
        });

        $(document).on('click', '.open-detail', function() {
            let modal = $('#detail-modal');
            let content = modal.find('.modal-content');
            let date = $(this).attr('data-date');
            
            modal.find('#detail-date').html(date);

            loadMeetingTable(date);

            modal.removeClass('hidden').addClass('flex');

            setTimeout(() => {
                modal.removeClass('opacity-0');
                content.removeClass('scale-95 translate-y-4 opacity-0');
                content.addClass('scale-100 translate-y-0 opacity-100');
            }, 10);
        })

        $('#confirm-availability').click(function(){
            $.ajax({
                url:'/meeting',
                type:'POST',
                data:{
                    _token:$('meta[name="csrf-token"]').attr('content'),
                    date:selectedDate,
                    start:selectedStart,
                    end:selectedEnd
                },
                success:function(){
                    $('#availability-modal').addClass('hidden');

                    loadMeetingTable(selectedDate);
                }
            });
        });
    });
</script>
@endsection