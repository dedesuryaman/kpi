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
        Schema::create('abc_result_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('abc_result_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('kpi_master_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('weight', 15, 10);

            $table->timestamps();

            $table->unique([
                'abc_result_id',
                'kpi_master_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abc_result_details');
    }
};
