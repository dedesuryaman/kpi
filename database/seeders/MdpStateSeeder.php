<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdpState;

class MdpStateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [

            [
                'code' => 'S1',
                'name' => 'Critical',
                'min_score' => 0,
                'max_score' => 40,
                'color' => 'danger',
                'description' => 'Employee performance is very poor.'
            ],

            [
                'code' => 'S2',
                'name' => 'Poor',
                'min_score' => 40.01,
                'max_score' => 60,
                'color' => 'warning',
                'description' => 'Employee needs improvement.'
            ],

            [
                'code' => 'S3',
                'name' => 'Good',
                'min_score' => 60.01,
                'max_score' => 80,
                'color' => 'info',
                'description' => 'Employee performs well.'
            ],

            [
                'code' => 'S4',
                'name' => 'Excellent',
                'min_score' => 80.01,
                'max_score' => 100,
                'color' => 'success',
                'description' => 'Outstanding employee.'
            ]

        ];

        foreach ($states as $state) {

            MdpState::updateOrCreate(
                ['code' => $state['code']],
                $state
            );
        }
    }
}
