<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbcIterationSeeder extends Seeder
{
    public function run(): void
    {
        $periodId = DB::table('periods')
            ->where('status', 'active')
            ->value('id');

        DB::table('abc_iterations')->insert([
            [
                'period_id' => $periodId,
                'iteration' => 1,
                'best_fitness' => 0.81250000,
                'avg_fitness' => 0.73540000,
                'convergence_rate' => 0.000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_id' => $periodId,
                'iteration' => 2,
                'best_fitness' => 0.84520000,
                'avg_fitness' => 0.78230000,
                'convergence_rate' => 0.032700,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_id' => $periodId,
                'iteration' => 3,
                'best_fitness' => 0.89170000,
                'avg_fitness' => 0.83120000,
                'convergence_rate' => 0.046500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
