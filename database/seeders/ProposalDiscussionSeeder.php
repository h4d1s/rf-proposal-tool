<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalDiscussionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Proposal::with("project") as $proposal) {
            $discussions = Discussion::factory()->count(rand(2, 5))->make();

            foreach ($discussions as $discussion) {
                $customer = $proposal->project->projectable;
                $team_id = $customer->team->id;
                $user = User::where('team_id', $team_id)->get()->random();
                $discussionable = collect([
                    $customer,
                    $user,
                ])->random();
                $discussion->discussionable()->associate($discussionable);
                $discussion->proposal()->associate($proposal);
                $discussion->save();
            }

            $proposal->discussions()->saveMany($discussions);
        }
    }
}
