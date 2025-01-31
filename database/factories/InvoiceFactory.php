<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(0, 100),
            'participants' => $this->faker->numberBetween(0, 100),
            'non_paying_participants' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['paid', 'unpaid']),
            'recipient_id' => $this->faker->numberBetween(1, 10),
            'sent_at' => $this->faker->dateTime,
        ];
    }
}
