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
        Schema::create('employee_performance_ai_analysis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('performance_result_id')
                ->constrained('employee_performance_results')
                ->cascadeOnDelete();

            $table->string('provider')->default('gemini');
            $table->string('model')->nullable();

            $table->text('summary')->nullable();

            $table->text('strengths')->nullable();

            $table->text('weaknesses')->nullable();

            $table->text('opportunities')->nullable();

            $table->text('risks')->nullable();

            $table->longText('recommendation')->nullable();

            $table->text('reward_recommendation')->nullable();

            $table->text('punishment_recommendation')->nullable();

            $table->decimal('overall_score', 5, 2)->nullable();

            $table->decimal('confidence', 5, 2)->nullable();

            $table->longText('prompt')->nullable();

            $table->longText('response')->nullable();

            $table->timestamp('analyzed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_performance_ai_analysis');
    }
};
