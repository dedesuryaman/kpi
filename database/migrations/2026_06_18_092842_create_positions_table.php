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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('department_id')
            //     ->nullable()
            //     ->constrained('departments')
            //     ->nullOnDelete();

            $table->string('name', 100);
            $table->string('description', 255)
                ->nullable();

            $table->timestamps();

            //$table->index('department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
