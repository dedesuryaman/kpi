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
                'name' => 'Promotion',
                'color' => 'success'
            ],

            [
                'code' => 'BONUS',
                'name' => 'Bonus',
                'color' => 'primary'
            ],

            [
                'code' => 'COACHING',
                'name' => 'Coaching',
                'color' => 'warning'
            ],

            [
                'code' => 'WARNING',
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
