<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MdpRewardSeeder extends Seeder
{
    public function run(): void
    {
        $s1 = DB::table('mdp_states')->where('code', 'S1')->value('id');
        $s2 = DB::table('mdp_states')->where('code', 'S2')->value('id');
        $s3 = DB::table('mdp_states')->where('code', 'S3')->value('id');
        $s4 = DB::table('mdp_states')->where('code', 'S4')->value('id');
        $s5 = DB::table('mdp_states')->where('code', 'S5')->value('id');

        $reward     = DB::table('mdp_actions')->where('name', 'Reward')->value('id');
        $bonus      = DB::table('mdp_actions')->where('name', 'Bonus')->value('id');
        $coaching   = DB::table('mdp_actions')->where('name', 'Coaching')->value('id');
        $training   = DB::table('mdp_actions')->where('name', 'Training')->value('id');
        $monitoring = DB::table('mdp_actions')->where('name', 'Monitoring')->value('id');
        $punishment = DB::table('mdp_actions')->where('name', 'Punishment')->value('id');

        DB::table('mdp_rewards')->insert([
            [
                'state_id' => $s5,
                'action_id' => $reward,
                'reward_value' => 100,
                'cost' => 10,
                'utility' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'state_id' => $s5,
                'action_id' => $bonus,
                'reward_value' => 120,
                'cost' => 30,
                'utility' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'state_id' => $s3,
                'action_id' => $training,
                'reward_value' => 70,
                'cost' => 20,
                'utility' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'state_id' => $s2,
                'action_id' => $monitoring,
                'reward_value' => 40,
                'cost' => 10,
                'utility' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'state_id' => $s1,
                'action_id' => $punishment,
                'reward_value' => -50,
                'cost' => 5,
                'utility' => -55,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
