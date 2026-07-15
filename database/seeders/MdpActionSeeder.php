<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdpAction;

class MdpActionSeeder extends Seeder
{
    public function run(): void
    {
        $actions = [

            [
                'code' => 'PROMOTION',
                'period_id' => 1,
                'name' => 'Promotion',
                'color' => 'success'
            ],

            [
                'code' => 'BONUS',
                'period_id' => 1,
                'name' => 'Bonus',
                'color' => 'primary'
            ],

            [
                'code' => 'COACHING',
                'period_id' => 1,
                'name' => 'Coaching',
                'color' => 'warning'
            ],

            [
                'code' => 'WARNING',
                'period_id' => 1,
                'name' => 'Warning Letter',
                'color' => 'danger'
            ]

        ];

        foreach ($actions as $action) {

            MdpAction::updateOrCreate(
                ['code' => $action['code']],
                $action
            );
        }
    }
}
