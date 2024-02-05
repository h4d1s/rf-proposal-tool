<?php

namespace Database\Seeders;

use App\Models\ServiceTemplate;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamServiceTemplateSeeder extends Seeder
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
            $templates = ServiceTemplate::factory()
                ->count(rand(3, 5))
                ->make();
            $team->serviceTemplates()->saveMany($templates);
        }
    }
}
