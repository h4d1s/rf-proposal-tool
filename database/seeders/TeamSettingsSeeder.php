<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSettingsSeeder extends Seeder
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
            $setting = Setting::make([
                "key" => "currency",
                "value" => "$"
            ]);
            $setting->team()->associate($team)->save();
        }
    }
}
