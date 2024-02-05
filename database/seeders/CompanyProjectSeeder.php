<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Company::lazy() as $company) {
            Project::factory()
                ->count(rand(2, 4))
                ->make()
                ->each(function($project) use ($company) {
                    $project->projectable()->associate($company)->save();
                });
        }
    }
}
