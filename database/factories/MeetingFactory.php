<?php

namespace Database\Factories;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Meeting>
 */
class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'time' => fake()->time('H:i'),
            'lesson_plan' => fake()->paragraph(),
            'term' => fake()->randomElement(['Term 1', 'Term 2', 'Term 3', 'Term 4']),
            'parent_id' => User::factory(),
            'student_id' => User::factory(),
            'teacher_id' => User::factory(),
        ];
    }
}
