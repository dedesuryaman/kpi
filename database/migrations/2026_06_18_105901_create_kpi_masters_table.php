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
        Schema::create('kpi_masters', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('division_id')
            //     ->constrained('divisions')
            //     ->cascadeOnUpdate()
            //     ->restrictOnDelete();

            // $table->foreignId('period_id')
            //     ->constrained('periods')
            //     ->cascadeOnUpdate()
            //     ->restrictOnDelete();

            $table->string('name', 200);

            $table->text('description')
                ->nullable();

            $table->integer('status')
                ->default(1);

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_masters');
    }
};
