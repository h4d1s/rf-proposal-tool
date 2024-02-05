<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TeamCollectionSeeder extends Seeder
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
            Collection::factory()
                ->count(rand(1, 30))
                ->make()
                ->each(function($collection) use ($team) {
                    $collection->team()->associate($team)->save();
                });
        }
    }
}
