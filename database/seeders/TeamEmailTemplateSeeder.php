<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamEmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Team::lazy() as $team) {
            $template = EmailTemplate::make([
                "name" => "Proposal send",
                "subject" => "Proposal [ProposalName]",
                "body" => "# Proposal [ProposalName]\n\nHello [CustomerName],\n\nI'm sending you our proposal, you can view it here:\n[LinkToProposal]\n\nThanks,\n[UserName]"
            ]);
            $template
                ->team()
                ->associate($team)
                ->save();
        }
    }
}
