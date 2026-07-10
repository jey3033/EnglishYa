<?php

namespace Database\Factories;

use App\Models\TransactionHeader;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransactionHeader>
 */
class TransactionHeaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice' => 'INV-' . fake()->unique()->numberBetween(1000, 9999),
            'date' => fake()->dateTime(),
            'total' => fake()->randomFloat(2, 10, 10000),
            'parent_id' => User::factory(),
            'teacher_id' => User::factory(),
        ];
    }
}
