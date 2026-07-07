<?php

namespace Database\Seeders;

use App\Models\User;
use Google\Service\DatabaseMigrationService\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            RolePermissionSeeder::class,
            DivisionSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,

            PeriodSeeder::class,
            KpiMasterSeeder::class,
            KpiIndicatorSeeder::class,

            //KpiIndicatorValueSeeder::class,

            KpiTargetSeeder::class,
            KpiScoreSeeder::class,
            KpiWeightHistorySeeder::class,

            AbcPopulationSeeder::class,
            AbcIterationSeeder::class,
            AbcBestSolutionSeeder::class,
            AbcHistorySeeder::class,

            MdpStateSeeder::class,

            MdpActionSeeder::class,

            MdpTransitionProbabilitySeeder::class,


            PerformanceIndicatorSeeder::class,

            //MdpStateSeeder::class,
            //MdpActionSeeder::class,
            //MdpTransitionSeeder::class,

            //MdpRewardSeeder::class,

        ]);
    }
}
