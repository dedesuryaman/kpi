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
        Schema::create('employee_performance_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('performance_result_id');

            $table->foreignId('kpi_master_id');

            $table->decimal('score', 5, 2)->default(0);
            $table->decimal('weight', 5, 2)->default(0);
            $table->decimal('weighted_score', 6, 2)->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign(
                'performance_result_id',
                'epd_perf_fk'
            )->references('id')
                ->on('employee_performance_results')
                ->cascadeOnDelete();

            $table->foreign(
                'kpi_master_id',
                'epd_master_fk'
            )->references('id')
                ->on('kpi_masters')
                ->cascadeOnDelete();

            $table->unique(
                ['performance_result_id', 'kpi_master_id'],
                'epd_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_performance_details');
    }
};
