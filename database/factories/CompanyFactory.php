<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique(true)->words(rand(2, 4), true)),
            'email' => $this->faker->unique(true)->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
