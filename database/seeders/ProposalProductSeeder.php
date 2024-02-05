<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Proposal;
use Illuminate\Database\Seeder;

class ProposalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proposals = Proposal::with("project.projectable.team")->get();
        foreach ($proposals as $proposal) {
            $team_id = $proposal->project->projectable->team->id;
            $products = Product::where("team_id", $team_id)
                ->inRandomOrder()
                ->take(rand(1, 10));
            $proposal
                ->products()
                ->attach($products->pluck('id'));
        }
    }
}
