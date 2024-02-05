<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TeamUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = Team::all()->random();
        $admin = User::factory()->make([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
        ]);
        $admin->team()->associate($team)->save();

        foreach (Team::lazy() as $team) {
            $users = User::factory()
                ->count(rand(2, 4))
                ->make();
            $team->users()->saveMany($users);
        }
    }
}
