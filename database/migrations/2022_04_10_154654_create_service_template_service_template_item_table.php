<?php

use App\Models\ServiceTemplate;
use App\Models\ServiceTemplateItem;
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
        Schema::create('s_t_s_t_item', function (Blueprint $table) {
            $table
                ->foreignIdFor(ServiceTemplateItem::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreignIdFor(ServiceTemplate::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['service_template_id', 'service_template_item_id']);
            $table->unique(['service_template_id', 'service_template_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_t_s_t_item');
    }
};
