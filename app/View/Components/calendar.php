<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
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

        while ($start <= $end) {
            $days[] = [
                'date' => $start->copy(),
                'day' => $start->day,
                'currentMonth' => $start->month == $month->month,
                'today' => $start->isToday(),
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