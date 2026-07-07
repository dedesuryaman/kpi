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
        Schema::create('employee_performance_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('period_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('average_score', 8, 2)->default(0);

            $table->decimal('final_score', 8, 2)->default(0);

            $table->char('grade', 1)->nullable();

            $table->unsignedInteger('rank')->nullable();

            // $table->string('reward_type')->nullable();

            $table->enum('approval_status', [
                'Pending',
                'Approved',
                'Rejected',
                'Waiting'
            ])->default('Waiting');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            // $table->timestamp('effective_date')->nullable();


            $table->timestamp('approved_at')->nullable();

            $table->text('approval_notes')->nullable();


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
        Schema::dropIfExists('employee_performance_results');
    }
};
