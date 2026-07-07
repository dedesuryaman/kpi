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

        Schema::create('kpi_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('indicator_id')
                ->constrained('kpi_indicators')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table->foreignId('period_id')
                ->constrained('periods')
                ->cascadeOnDelete();

            $table->decimal('score', 8, 2);

            $table->decimal('final_score', 8, 2)
                ->default(0);

            $table->foreignId('assessor_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('assessment_date');

            $table->text('notes')
                ->nullable();

            // $table->foreignId('period_id')
            //     ->constrained('periods')
            //     ->cascadeOnUpdate()
            //     ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'employee_id',
                'indicator_id',
                'period_id'
            ], 'employee_indicator_period_score_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_scores');
    }
};
