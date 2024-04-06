<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'descriptions' => $this->faker->sentence,
            'stocks' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement([0, 1]),
            'price' => $this->faker->randomElement([5, 100]),
        ];
    }
}
