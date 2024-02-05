<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Client;
use Illuminate\Database\Seeder;

class ActivityClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for ($i = 0; $i < 50; $i++) {
            Client::with("projects")
                ->inRandomOrder()
                ->take(rand(1, 10))
                ->get()
                ->each(function ($client) use (&$data) {
                    if (is_null($client->projects)) {
                        return;
                    }

                    if ($client->projects->count() === 0) {
                        return;
                    }

                    $project = $client->projects()->inRandomOrder()->first();
                    if (is_null($project->proposals)) {
                        return;
                    }

                    if ($project->proposals->count() === 0) {
                        return;
                    }

                    $proposal = $project->proposals()->inRandomOrder()->first();
                    $type = ActivityType::all()->random();

                    $activity = new Activity();
                    $team = $client->team;
                    $activity->team()->associate($team);
                    $activity->subject()->associate($proposal);
                    $activity->causer()->associate($client);
                    $activity->activity_type()->associate($type);
                    $data[] = $activity->getAttributes();
                });
        }
        Activity::insert($data);
    }
}
