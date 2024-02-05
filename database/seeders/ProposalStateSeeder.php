<?php

namespace Database\Seeders;

use App\Enums\ProposalState as ProposalStateEnum;
use App\Models\ProposalState;
use Illuminate\Database\Seeder;

class ProposalStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(ProposalStateEnum::cases())
            ->each(function ($case) {
                ProposalState::create([
                    'name' => $case->value,
                ]);
            });
    }
}
