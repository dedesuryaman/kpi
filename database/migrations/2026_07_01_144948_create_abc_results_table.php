<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abc_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('period_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('population_size');
            $table->unsignedInteger('max_iteration');
            $table->unsignedInteger('limit_trial');

            $table->decimal('fitness', 12, 8)->default(0);

            $table->decimal('attendance_weight', 10, 8);
            $table->decimal('productivity_weight', 10, 8);
            $table->decimal('quality_weight', 10, 8);
            $table->decimal('discipline_weight', 10, 8);
            $table->decimal('innovation_weight', 10, 8);

            $table->unsignedBigInteger('execution_time')->nullable();

            $table->boolean('is_best')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abc_results');
    }
};
