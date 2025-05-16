<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheckIns>
 */
class CheckInsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'check_in_time' => fake()->time(),
            'check_out_time' => fake()->time(),
            'check_date' => fake()->date(),
        ];
    }
}
