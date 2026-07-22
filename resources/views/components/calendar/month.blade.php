<div class="calendar-weekday">Sun</div>
<div class="calendar-weekday">Mon</div>
<div class="calendar-weekday">Tue</div>
<div class="calendar-weekday">Wed</div>
<div class="calendar-weekday">Thu</div>
<div class="calendar-weekday">Fri</div>
<div class="calendar-weekday">Sat</div>

{{-- Days --}}
@foreach($month['weeks'] as $week)
    @foreach($week as $day)
        <div class="calendar-day {{ !$day['currentMonth'] ? 'other-month' : 'open-detail' }} {{ $day['today'] ? 'today' : '' }}" data-date={{ $day['date'] }}>
            <div class="calendar-date">
                {{ $day['day'] }}
            </div>
            {{-- Future meetings go here --}}
            <div class="calendar-events">
                @foreach($day['meetings'] as $meeting)
                        <span class="teacher-color"
                            style="background: {{ Auth::user()->color }}">
                        </span>
                        {{ \Carbon\Carbon::parse($meeting->start)->format('H:i') }}
                @endforeach
            </div>
        </div>
    @endforeach
@endforeach
