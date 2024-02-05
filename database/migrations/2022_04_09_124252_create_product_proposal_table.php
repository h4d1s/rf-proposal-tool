<?php

use App\Models\Product;
use App\Models\Proposal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_proposal', function (Blueprint $table) {
            $table
                ->foreignIdFor(Product::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreignIdFor(Proposal::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['product_id', 'proposal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_proposal');
    }
};
