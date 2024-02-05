<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Client::lazy() as $client) {
            Project::factory()
                ->count(rand(2, 4))
                ->make()
                ->each(function($project) use ($client) {
                    $project->projectable()->associate($client)->save();
                });
        }
    }
}
