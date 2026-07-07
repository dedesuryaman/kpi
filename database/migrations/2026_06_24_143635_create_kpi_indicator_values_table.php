<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        return;

        Schema::create('kpi_indicator_values', function (Blueprint $table) {

            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->foreignId('kpi_indicator_id')
                ->constrained('kpi_indicators')
                ->cascadeOnDelete();

            $table->decimal('weight', 5, 2)->default(0);

            $table->decimal('target_value', 15, 2)->default(0);

            $table->decimal('actual_value', 15, 2)
                ->nullable();

            $table->decimal('score', 15, 2)
                ->default(0);

            $table->text('remarks')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'employee_id',
                'kpi_indicator_id'
            ], 'employee_indicator_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_indicator_values');
    }
};
