<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceTemplateItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->unique()->words(rand(2, 4), true)),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 10000),
            'qty' => $this->faker->numberBetween(1, 9),
        ];
    }
}
