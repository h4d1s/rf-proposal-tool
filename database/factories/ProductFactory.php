<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->unique(true)->words(rand(2, 4), true)),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(1, 5, 500),
            'rf_id' => rand(1, 5000),
        ];
    }
}
