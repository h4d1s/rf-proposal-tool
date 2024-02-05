<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\ProposalState;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Project::lazy() as $project) {
            Proposal::factory()
                ->count(rand(1, 3))
                ->make()
                ->each(function ($proposal) use ($project) {
                    $team_id = $project->projectable->team->id;
                   
                    $state = ProposalState::inRandomOrder()->first();
                    $proposal->state()->associate($state);
                    
                    $proposal->project()->associate($project);
                    
                    $user = User::whereHas('team', function ($query) use ($team_id) {
                        $query->where('id', $team_id);
                    })->inRandomOrder()->first();
                    $proposal->user()->associate($user);

                    $email_template = EmailTemplate::where("team_id", $team_id)
                        ->inRandomOrder()
                        ->first();
                    $proposal->emailTemplate()->associate($email_template);

                    $proposal->save();
                });
        }
    }
}
