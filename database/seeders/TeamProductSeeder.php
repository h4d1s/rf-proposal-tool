<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Team::lazy() as $team) {
            Product::factory()
                ->count(30)
                ->make()
                ->each(function($product) use ($team) {
                    $product
                        ->team()
                        ->associate($team)
                        ->save();
                });
        }
    }
}
