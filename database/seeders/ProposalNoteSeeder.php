<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Proposal;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalNoteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proposals = Proposal::with("project");
        foreach ($proposals as $proposal) {
            $notes = [];
            for ($i = 0; $i < rand(1, 6); $i++) {
                $note = Note::factory()->make();
                $team_id = $proposal->project->projectable->team->id;
                $user = User::where('team_id', $team_id)->get()->random();
                $note->user()->associate($user);
                $note->proposal()->associate($proposal);
                $notes[] = $note;
            }
            $proposal->notes()->saveMany($notes);
        }
    }
}
