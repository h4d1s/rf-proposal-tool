<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CollectionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collections = Collection::with("products")->lazy();
        foreach ($collections as $collection) {
            $team_id = $collection->team->id;
            $products = Product::whereHas("team", function($query) use ($team_id) {
                    $query->where("id", $team_id);
                })
                ->inRandomOrder()
                ->take(rand(1, 10))
                ->get();
            $collection
                ->products()
                ->saveMany($products);
        }
    }
}
