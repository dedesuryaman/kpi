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
        Schema::create('abc_iterations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('period_id')
                ->constrained('periods')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedInteger('iteration');

            $table->decimal('best_fitness', 15, 8);

            $table->decimal('avg_fitness', 15, 8);

            $table->decimal('convergence_rate', 10, 6)
                ->nullable();

            $table->timestamps();

            $table->unique([
                'period_id',
                'iteration'
            ], 'abc_iteration_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abc_iterations');
    }
};
