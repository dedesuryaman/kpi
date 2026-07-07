<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MdpTransitionSeeder extends Seeder
{
    public function run(): void
    {
        $periodId = DB::table('periods')
            ->where('status', 'active')
            ->value('id');

        $s1 = DB::table('mdp_states')->where('code', 'S1')->value('id');
        $s2 = DB::table('mdp_states')->where('code', 'S2')->value('id');
        $s3 = DB::table('mdp_states')->where('code', 'S3')->value('id');
        $s4 = DB::table('mdp_states')->where('code', 'S4')->value('id');
        $s5 = DB::table('mdp_states')->where('code', 'S5')->value('id');

        DB::table('mdp_transitions')->insert([
            [
                'from_state' => $s2,
                'to_state' => $s3,
                'probability' => 0.6500,
                'period_id' => $periodId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'from_state' => $s3,
                'to_state' => $s4,
                'probability' => 0.7000,
                'period_id' => $periodId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'from_state' => $s4,
                'to_state' => $s5,
                'probability' => 0.8000,
                'period_id' => $periodId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'from_state' => $s3,
                'to_state' => $s2,
                'probability' => 0.1500,
                'period_id' => $periodId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
