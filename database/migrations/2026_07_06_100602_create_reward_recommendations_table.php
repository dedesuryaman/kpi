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
        Schema::create('reward_recommendations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('performance_result_id')
                ->constrained('employee_performance_results')
                ->cascadeOnDelete();

            $table->string('reward_type', 100);

            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected'
            ])->default('Pending');

            $table->date('effective_date');

            $table->text('approval_notes')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index('performance_result_id');

            // $table->unique(
            //     ['performance_result_id'],
            //     'reward_perf_unique'
            // );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_recommendations');
    }
};
