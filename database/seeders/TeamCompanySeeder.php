<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamCompanySeeder extends Seeder
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
            Company::factory()
                ->count(rand(1, 3))
                ->make()
                ->each(function($client) use ($team) {
                    $client->team()->associate($team)->save();
                });
        }
    }
}
