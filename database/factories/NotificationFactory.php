<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => mt_rand(1, 2),
            'message' => $this->faker->sentence,
            'status' => mt_rand(1, 2),
            'link' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
