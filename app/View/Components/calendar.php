<?php

namespace App\View\Components;

use App\Models\Meeting;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Calendar extends Component
{
    public Carbon $current;
    public array $month;

    public function __construct(?int $year = null, ?int $month = null)
    {
        $this->current = Carbon::create(
            $year ?? now()->year,
            $month ?? now()->month,
            1
        );

        $this->month = $this->buildMonth($this->current);
    }

    /**
     * Build one month's calendar.
     */
    private function buildMonth(Carbon $month): array{
        $start = $month->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $end = $month->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        $days = [];

        $meetings = Meeting::where('teacher_id', Auth::id())->whereBetween('date', [
            $month->copy()->startOfMonth(),
            $month->copy()->endOfMonth(),
        ])->get()->groupBy(function ($meeting) {
            return Carbon::parse($meeting->date)->toDateString();
        });

        while ($start <= $end) {
            $days[] = [
                'date' => $start->copy(),
                'day' => $start->day,
                'currentMonth' => $start->month == $month->month,
                'today' => $start->isToday(),
                'meetings' => $meetings[$start->toDateString()] ?? collect(),
            ];
            $start->addDay();   
        }

        return [
            'title' => $month->format('F Y'),
            'month' => $month,
            'weeks' => collect($days)->chunk(7),
        ];
    }

    /**
     * Get the view.
     */
    public function render(): View|Closure|string
    {
        return view('components.calendar');
    }
}