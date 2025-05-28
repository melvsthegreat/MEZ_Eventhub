<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['deposit', 'withdrawal', 'transfer']),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'status' => fake()->randomElement(['pending', 'success', 'failed']),
        ];
    }
}
