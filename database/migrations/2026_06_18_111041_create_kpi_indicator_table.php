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
        Schema::create('kpi_indicators', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kpi_master_id')
                ->constrained('kpi_masters')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('name', 200);

            $table->text('description')
                ->nullable();

            // Bobot KPI (%)
            $table->decimal('weight', 5, 2)
                ->default(0);

            $table->decimal('min_score', 8, 2)
                ->default(0);

            $table->decimal('max_score', 8, 2)
                ->default(100);

            $table->enum('measurement_type', [
                'number',
                'percentage',
                'currency',
                'score',
                'boolean'
            ])->default('score');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_indicators');
    }
};
