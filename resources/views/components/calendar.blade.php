<div id="calendar" class="calendar" data-year="{{ $current->year }}" data-month="{{ $current->month }}">
    <div class="card-header calendar-header">
        <button id="calendar-prev" class="btn btn-light">←</button>
        <h2 id="calendar-title">{{ $month['title'] }}</h2>
        <button id="calendar-next" class="btn btn-light">→</button>
    </div>
    <div class="calendar-content" id="calendar-content">
        @include('components.calendar.month')
    </div>
</div>
<script>
    function loadCalendar(year, month){
        $.get(`/calendar/${year}/${month}`, function(res){
            $('#calendar-title').text(res.title);
            $('#calendar-content').html(res.html);
            $('#calendar').attr('data-year', res.year).attr('data-month', res.month);
        });

    }

    $(document).on('click','#calendar-prev',function(){
        let calendar = $('#calendar');
        let year = parseInt(calendar.attr('data-year'));
        let month = parseInt(calendar.attr('data-month'));
        month--;

        if(month < 1){
            month = 12;
            year--;
        }
        loadCalendar(year, month);
    });

    $(document).on('click','#calendar-next',function(){
        let calendar = $('#calendar');
        let year = parseInt(calendar.attr('data-year'));
        let month = parseInt(calendar.attr('data-month'));
        month++;

        if(month > 12){
            month = 1;
            year++;
        }
        loadCalendar(year, month);

    });
</script>