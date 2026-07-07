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
        Schema::create('mdp_transition_probabilities', function (Blueprint $table) {

            $table->id();

            $table->foreignId('from_state_id')
                ->constrained('mdp_states')
                ->cascadeOnDelete();

            $table->foreignId('to_state_id')
                ->constrained('mdp_states')
                ->cascadeOnDelete();

            $table->foreignId('action_id')
                ->constrained('mdp_actions')
                ->cascadeOnDelete();

            $table->decimal('probability', 8, 4);

            $table->decimal('reward', 10, 2)->default(0);

            $table->timestamps();

            $table->unique(
                ['from_state_id', 'to_state_id', 'action_id'],
                'mdp_tp_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mdp_transition_probabilities');
    }
};
