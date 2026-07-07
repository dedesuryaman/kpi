<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MdpPolicySeeder extends Seeder
{
    public function run(): void
    {
        $employeeId = DB::table('employees')->value('id');

        $periodId = DB::table('periods')
            ->where('status', 'active')
            ->value('id');

        $bonusAction = DB::table('mdp_actions')
            ->where('name', 'Bonus')
            ->value('id');

        DB::table('mdp_policies')->insert([
            [
                'employee_id' => $employeeId,
                'best_action' => $bonusAction,
                'expected_reward' => 95.5000,
                'recommendation' =>
                'Karyawan layak mendapatkan bonus dan penghargaan karena performa KPI berada pada kategori Sangat Baik.',
                'period_id' => $periodId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
