<?php

namespace Database\Factories;

use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pricePerHour = fake()->randomFloat(2, 10, 100);
        $hours = fake()->numberBetween(1, 10);
        $subtotal = $pricePerHour * $hours;

        return [
            'transaction_header_id' => TransactionHeader::factory(),
            'report_id' => Report::factory(),
            'price_per_hour' => $pricePerHour,
            'hours' => $hours,
            'subtotal' => $subtotal,
            'detail' => fake()->sentence(),
        ];
    }
}
