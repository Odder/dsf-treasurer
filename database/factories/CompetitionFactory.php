<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competition>
 */
class CompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wca_id' => $this->faker->word,
            'name' => $this->faker->word,
            'number_of_competitors' => $this->faker->numberBetween(0, 100),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'status' => $this->faker->randomElement(['past', 'current', 'future']),
        ];
    }
}
