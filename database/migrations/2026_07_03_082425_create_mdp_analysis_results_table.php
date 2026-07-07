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
        Schema::create('mdp_analysis_results', function (Blueprint $table) {

            $table->id();

            $table->foreignId('period_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('abc_result_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('employee_performance_result_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('state_id')
                ->constrained('mdp_states');

            $table->foreignId('action_id')
                ->constrained('mdp_actions');

            $table->decimal('reward', 10, 4);

            $table->decimal('discount_factor', 5, 2)->default(0.90);

            $table->text('recommendation')->nullable();

            $table->timestamps();

            $table->unique([
                'period_id',
                'employee_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mdp_analysis_results');
    }
};
