<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\PricingTable;
use App\Models\Proposal;
use App\Models\PricingTableItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalPricingTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Proposal::lazy() as $proposal) {
            $pricingTable = PricingTable::factory()->make();
            $proposal->pricingTable()->associate($pricingTable)->save();
        }
    }
}
