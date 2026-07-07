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
        return;

        Schema::create('mdp_transitions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('from_state')
                ->constrained('mdp_states')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('to_state')
                ->constrained('mdp_states')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->decimal('probability', 8, 4);

            $table->foreignId('period_id')
                ->constrained('periods')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'from_state',
                'to_state',
                'period_id'
            ], 'mdp_transition_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mdp_transitions');
    }
};
