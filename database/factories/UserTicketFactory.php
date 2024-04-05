<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTicket>
 */
class UserTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement([1, 10]),
            'ticket_id' => $this->faker->randomElement([1, 10]),
            'status' => $this->faker->randomElement([0, 1]),
            'amount' => $this->faker->numberBetween(1, 10),
            'code' => $this->faker->unique()->word,
        ];
    }
}
