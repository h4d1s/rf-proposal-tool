<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $expiration_date = $this->faker->dateTimeBetween('now', '1 month')->format('Y-m-d H:i');
        $created_at = $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i');

        return [
            'name' => ucfirst($this->faker->unique()->words(rand(2, 4), true)),
            'cover_letter' => $this->faker->paragraph(3),
            'conclusion' => $this->faker->paragraph(),
            'expiration_date' => $expiration_date,
            'created_at' => $created_at,
        ];
    }
}
