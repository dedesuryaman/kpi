<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $corporate = DB::table('divisions')
            ->where('name', 'Corporate')
            ->value('id');

        $operations = DB::table('divisions')
            ->where('name', 'Operations')
            ->value('id');

        $supplyChain = DB::table('divisions')
            ->where('name', 'Supply Chain')
            ->value('id');

        $businessDev = DB::table('divisions')
            ->where('name', 'Business Development')
            ->value('id');

        DB::table('departments')->insert([
            [
                'division_id' => $corporate,
                'name' => 'Human Resource',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'division_id' => $corporate,
                'name' => 'Finance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'division_id' => $corporate,
                'name' => 'Information Technology',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'division_id' => $operations,
                'name' => 'Production',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'division_id' => $operations,
                'name' => 'Quality Control',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'division_id' => $operations,
                'name' => 'Warehouse',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'division_id' => $supplyChain,
                'name' => 'Purchasing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'division_id' => $businessDev,
                'name' => 'Marketing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
