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
        Schema::create('mdp_states', function (Blueprint $table) {

            $table->id();

            $table->string('code', 10)->unique();

            $table->integer('period_id')->unsigned();

            $table->string('name');

            $table->decimal('min_score', 8, 2);

            $table->decimal('max_score', 8, 2);

            $table->string('color', 20)->default('secondary');

            $table->text('description')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mdp_states');
    }
};
