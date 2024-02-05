<?php

namespace Database\Seeders;

use App\Enums\ActivityType as EnumsActivityType;
use App\Enums\ProposalState;
use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(EnumsActivityType::cases())
            ->each(function ($case) {
                ActivityType::create([
                    'name' => $case->value,
                ]);
            });
    }
}
