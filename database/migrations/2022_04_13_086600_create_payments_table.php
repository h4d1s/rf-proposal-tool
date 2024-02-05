<?php


use App\Models\Client;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->boolean('is_paid');
            $table->morphs('paymentable');

            $table
                ->foreignIdFor(Proposal::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['paymentable_id', 'proposal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
