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
        Schema::create('mdp_rewards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('state_id')
                ->constrained('mdp_states')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('action_id')
                ->constrained('mdp_actions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->decimal('reward_value', 15, 2)
                ->default(0);

            $table->decimal('cost', 15, 2)
                ->default(0);

            $table->decimal('utility', 15, 4)
                ->default(0);

            $table->timestamps();

            $table->unique([
                'state_id',
                'action_id'
            ], 'mdp_reward_state_action_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mdp_rewards');
    }
};
