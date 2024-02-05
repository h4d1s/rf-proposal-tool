<?php

namespace Database\Seeders;

use App\Models\ServiceTemplate;
use App\Models\ServiceTemplateItem;
use Illuminate\Database\Seeder;

class ServiceTemplateServiceTemplateItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ServiceTemplate::lazy() as $serviceTemplate) {
            $items = ServiceTemplateItem::factory()
                ->count(rand(1, 10))
                ->make();
            $serviceTemplate
                ->items()
                ->saveMany($items);
        }
    }
}