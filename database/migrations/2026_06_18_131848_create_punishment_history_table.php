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
        Schema::create('punishment_history', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('type', [
                'warning',
                'coaching',
                'salary_cut',
                'demotion',
                'suspension',
                'termination'
            ]);

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('low');

            $table->text('notes')
                ->nullable();

            $table->foreignId('approved_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('period_id')
                ->constrained('periods')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index('employee_id');
            $table->index('type');
            $table->index('severity');
            $table->index('period_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punishment_history');
    }
};
