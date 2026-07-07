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
        Schema::create('abc_populations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('period_id')
                ->constrained('periods')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Nomor food source
            $table->unsignedInteger('food_source');

            // Nilai fitness hasil evaluasi
            $table->decimal('fitness', 15, 8)
                ->default(0);

            // Bobot KPI dalam format JSON
            $table->json('weight_json');

            $table->enum('status', [
                'employed',
                'onlooker',
                'scout',
                'best'
            ])->default('employed');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abc_populations');
    }
};
