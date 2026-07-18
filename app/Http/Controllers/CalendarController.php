<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function calendar($year, $month) {
        $current = Carbon::create($year, $month, 1);
        $monthData = $this->buildMonth($current);

        return response()->json([
            'title' => $monthData['title'],
            'year'  => $current->year,
            'month' => $current->month,
            'html'  => view('components.calendar.month', [
                'month' => $monthData
            ])->render(),
        ]);
    }

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
}