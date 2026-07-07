<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdpState;
use App\Models\MdpAction;
use App\Models\MdpTransitionProbability;

class MdpTransitionProbabilitySeeder extends Seeder
{
    public function run(): void
    {
        $critical = MdpState::where('code', 'S1')->first();
        $poor = MdpState::where('code', 'S2')->first();
        $good = MdpState::where('code', 'S3')->first();
        $excellent = MdpState::where('code', 'S4')->first();

        $promotion = MdpAction::where('code', 'PROMOTION')->first();
        $bonus = MdpAction::where('code', 'BONUS')->first();
        $coaching = MdpAction::where('code', 'COACHING')->first();
        $warning = MdpAction::where('code', 'WARNING')->first();

        $rows = [

            // Critical
            [$critical, $poor, $coaching, 0.70, 40],
            [$critical, $critical, $warning, 0.30, -20],

            // Poor
            [$poor, $good, $coaching, 0.70, 60],
            [$poor, $poor, $warning, 0.30, -10],

            // Good
            [$good, $excellent, $bonus, 0.80, 85],
            [$good, $good, $bonus, 0.20, 75],

            // Excellent
            [$excellent, $excellent, $promotion, 1.00, 100],

        ];

        foreach ($rows as $row) {

            MdpTransitionProbability::updateOrCreate(

                [

                    'from_state_id' => $row[0]->id,

                    'to_state_id' => $row[1]->id,

                    'action_id' => $row[2]->id,

                ],

                [

                    'probability' => $row[3],

                    'reward' => $row[4]

                ]

            );
        }
    }
}
