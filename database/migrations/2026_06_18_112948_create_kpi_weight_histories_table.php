<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('kpi_weight_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('indicator_id')
                ->constrained('kpi_indicators')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->decimal('old_weight', 8, 4);

            $table->decimal('new_weight', 8, 4);

            $table->string('algorithm', 50)
                ->default('ABC');

            $table->timestamp('created_at')
                ->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_weight_histories');
    }
};
