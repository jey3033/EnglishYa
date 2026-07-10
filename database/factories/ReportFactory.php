<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meeting_number' => 'MTG-' . fake()->unique()->numberBetween(1000, 9999),
            'meeting_date' => fake()->date(),
            'meeting_report' => fake()->paragraph(),
            'term' => fake()->randomElement(['Term 1', 'Term 2', 'Term 3', 'Term 4']),
            'time_start' => fake()->time('H:i'),
            'time_end' => fake()->time('H:i'),
            'parent_id' => User::factory(),
            'student_id' => User::factory(),
            'teacher_id' => User::factory(),
        ];
    }
}
