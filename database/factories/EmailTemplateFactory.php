<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailTemplate>
 */
class EmailTemplateFactory extends Factory
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
            'subject' => ucfirst($this->faker->unique(true)->words(rand(2, 6), true)),
            'body' => $this->faker->paragraph(),
        ];
    }
}
