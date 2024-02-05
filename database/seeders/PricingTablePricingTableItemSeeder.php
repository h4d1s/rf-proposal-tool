<?php

namespace Database\Seeders;

use App\Models\PricingTable;
use App\Models\PricingTableItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricingTablePricingTableItemSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (PricingTable::lazy() as $table) {
            $items = PricingTableItem::factory()
                ->count(rand(3, 5))
                ->create();
            $table
                ->items()
                ->saveMany($items);
        }
    }
}
