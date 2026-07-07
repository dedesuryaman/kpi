<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('divisions')->insert([
            [
                'name' => 'Corporate',
                'description' => 'Divisi pendukung operasional perusahaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operations',
                'description' => 'Divisi yang bertanggung jawab terhadap proses produksi dan operasional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supply Chain',
                'description' => 'Divisi pengadaan dan pengelolaan rantai pasok.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business Development',
                'description' => 'Divisi pemasaran dan pengembangan bisnis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
