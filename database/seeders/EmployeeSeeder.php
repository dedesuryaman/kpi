<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $itDept = DB::table('departments')
            ->where('name', 'Information Technology')
            ->value('id');

        $hrDept = DB::table('departments')
            ->where('name', 'Human Resource')
            ->value('id');

        $directorPosition = DB::table('positions')
            ->where('name', 'Director')
            ->value('id');

        $managerPosition = DB::table('positions')
            ->where('name', 'Manager')
            ->value('id');

        $supervisorPosition = DB::table('positions')
            ->where('name', 'Supervisor')
            ->value('id');

        $staffPosition = DB::table('positions')
            ->where('name', 'Staff Unit')
            ->value('id');

        $employeeCodes = [
            'MT20010119002',
            'MT20021220006',
            'MT19990621011',
            'MT20030822015',
            'MT20030822018',
            'MT19810122026',
            'MT20010823027',
            'MT19980123028',
            'MT19991023030',
            'MT20041223033',
            'MT19991223036',
            'MT20000324037',
            'MT20050124038',
            'MT19810224041',
            'MT20051024042',
            'MT20020224043',
            'MT20020224044',
            'MT19960425045',
            'MT19950525046',
            'MT19950825047',
            'MT19950825048',
        ];

        // Nama Sunda (base)
        $firstNames = [
            'Asep',
            'Dedi',
            'Rina',
            'Siti',
            'Yayan',
            'Tatang',
            'Dian',
            'Lilis',
            'Nina',
            'Euis',
            'Ujang',
            'Jajang',
            'Cecep',
            'Iwan',
            'Agus',
            'Wawan',
            'Tati',
            'Sri',
            'Yuli',
            'Rudi',
            'Nenden',
            'Ika',
            'Rika',
            'Susi',
            'Budi',
            'Maman',
            'Dadan',
            'Fajar',
            'Indra',
            'Rendi'
        ];

        $lastNames = [
            'Kurniawan',
            'Saputra',
            'Permana',
            'Wijaya',
            'Santoso',
            'Hidayat',
            'Firmansyah',
            'Ramadhan',
            'Maulana',
            'Pratama',
            'Suryana',
            'Gumilar',
            'Hermawan',
            'Gunawan',
            'Setiawan',
            'Purnama',
            'Wibowo',
            'Putra',
            'Nugraha',
            'Ramdani'
        ];

        $birthPlaces = [
            'Bandung',
            'Garut',
            'Tasikmalaya',
            'Cianjur',
            'Sumedang',
            'Subang',
            'Cirebon',
            'Purwakarta',
            'Bogor',
            'Sukabumi',
        ];

        $streets = [
            'Jl. Merdeka',
            'Jl. Asia Afrika',
            'Jl. Soekarno Hatta',
            'Jl. Ahmad Yani',
            'Jl. Gatot Subroto',
            'Jl. Cikutra',
            'Jl. Supratman',
            'Jl. Diponegoro',
            'Jl. Pasteur',
            'Jl. Buah Batu',
        ];

        $religions = [
            'Islam',
            'Kristen',
            'Katholik',
            'Hindu',
            'Buddha',
            'Konghucu',
        ];


        $getBirthPlace = function () use ($birthPlaces) {
            return $birthPlaces[array_rand($birthPlaces)];
        };

        $getBirthDate = function ($minAge = 35, $maxAge = 55) {
            return now()->subYears(rand($minAge, $maxAge))
                ->subDays(rand(0, 364))
                ->format('Y-m-d');
        };

        $getPhone = function () {
            return '08'
                . rand(11, 99)
                . rand(1000, 9999)
                . rand(1000, 9999);
        };

        $getAddress = function () use ($streets, $birthPlaces) {
            return $streets[array_rand($streets)]
                . ' No. '
                . rand(1, 250)
                . ', '
                . $birthPlaces[array_rand($birthPlaces)];
        };

        $getGender = fn() => rand(0, 1) ? 'P' : 'W';

        $getReligion = function () use ($religions) {
            // Mayoritas Islam agar lebih realistis
            return rand(1, 100) <= 90
                ? 'Islam'
                : $religions[array_rand($religions)];
        };


        $counter = 0;

        $getEmployeeCode = function () use (&$counter, $employeeCodes) {
            return $employeeCodes[$counter++] ?? 'EMP' . str_pad($counter, 5, '0', STR_PAD_LEFT);
        };


        // =====================
        // Director (1 orang)
        // =====================
        $directorName = 'Budi Santoso';
        $directorEmail = 'director@example.com';

        $directorId = DB::table('employees')->insertGetId([
            'employee_code' => $getEmployeeCode(),
            'name' => $directorName,
            'email' => $directorEmail,

            'birth_place' => $getBirthPlace(),
            'birth_date' => $getBirthDate(40, 55),

            'gender' => $getGender(),

            'phone' => $getPhone(),
            'address' => $getAddress(),
            'religion' => $getReligion(),

            'department_id' => null, // atau HR jika memang Director masuk HR
            'position_id' => $directorPosition,
            'leader_id' => null,
            'join_date' => '2018-01-01',
            'employment_status' => 'permanent',
            'salary' => 25000000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'employee_id' => $directorId,
            'name' => $directorName,
            'email' => $directorEmail,
            'password' => Hash::make('password'),
        ])->assignRole('Director');



        $managerName = 'Asep Gunawan';
        $managerEmail = 'manager@example.com';


        // =====================
        // Manager (1 orang)
        // =====================

        $managerId = DB::table('employees')->insertGetId([
            'employee_code' => $getEmployeeCode(),
            'name' => 'Asep Gunawan',
            'email' => 'manager@example.com',

            'birth_place' => $getBirthPlace(),
            'birth_date' => $getBirthDate(40, 55),

            'gender' => $getGender(),

            'phone' => $getPhone(),
            'address' => $getAddress(),
            'religion' => $getReligion(),


            'department_id' => $hrDept,
            'position_id' => $managerPosition,
            'leader_id' => $directorId,
            'join_date' => '2020-01-01',
            'employment_status' => 'permanent',
            'salary' => 15000000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $user = User::create([
            'employee_id' => $managerId,
            'name'        => $managerName,
            'email'       => $managerEmail,
            'password'    => Hash::make('password'),
        ]);

        $user->assignRole('Manager');

        // =====================
        // Supervisor (2 orang)
        // =====================
        $supervisors = [];



        for ($i = 0; $i < 2; $i++) {
            $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
            $email = 'supervisor' . $i . '@example.com';


            // $supervisors[] = DB::table('employees')->insertGetId([
            //     'employee_code' => $getEmployeeCode(),
            //     'name' => $name,
            //     'department_id' => $i % 2 == 0 ? $itDept : $hrDept,
            //     'position_id' => $supervisorPosition,
            //     'leader_id' => $managerId,
            //     'join_date' => now()->subYears(rand(1, 3)),
            //     'employment_status' => 'permanent',
            //     'salary' => 10000000,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);

            $employeeId = DB::table('employees')->insertGetId([
                'employee_code' => $getEmployeeCode(),
                'name' => $name,
                'email' => $email,

                'birth_place' => $getBirthPlace(),
                'birth_date' => $getBirthDate(40, 55),

                'gender' => $getGender(),

                'phone' => $getPhone(),
                'address' => $getAddress(),
                'religion' => $getReligion(),


                'department_id' => $i % 2 == 0 ? $itDept : $hrDept,
                'position_id' => $supervisorPosition,
                'leader_id' => $managerId,
                'join_date' => now()->subYears(rand(1, 3)),
                'employment_status' => 'permanent',
                'salary' => 10000000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user = User::create([
                'employee_id' => $employeeId,
                'name'        => $name,
                'email'       => $email,
                'password'    => Hash::make('password'),
            ]);

            $user->assignRole('Supervisor');

            $supervisors[] = $employeeId;
        }

        // =====================
        // Staff (97 orang = total 100)
        // =====================
        for ($i = 0; $i < 17; $i++) {

            $leader = $supervisors[array_rand($supervisors)];

            $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
            $email = 'staff' . $i . '@example.com';

            $employeeId = DB::table('employees')->insertGetId([
                'employee_code' => $getEmployeeCode(),
                'name' => $name,
                'email' => $email,

                'birth_place' => $getBirthPlace(),
                'birth_date' => $getBirthDate(40, 55),

                'gender' => $getGender(),

                'phone' => $getPhone(),
                'address' => $getAddress(),
                'religion' => $getReligion(),


                'department_id' => $i % 2 == 0 ? $itDept : $hrDept,
                'position_id' => $staffPosition,
                'leader_id' => $leader,
                'join_date' => now()->subDays(rand(30, 1500)),
                'employment_status' => rand(0, 1) ? 'permanent' : 'contract',
                'salary' => rand(5000000, 9000000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user = User::create([
                'employee_id' => $employeeId,
                'name'        => $name,
                'email'       => $email,
                'password'    => Hash::make('password'),
            ]);

            $user->assignRole('Employee');


            // DB::table('employees')->insert([
            //     'employee_code' => $getEmployeeCode(),
            //     'name' => $name,
            //     'department_id' => $i % 2 == 0 ? $itDept : $hrDept,
            //     'position_id' => $staffPosition,
            //     'leader_id' => $leader,
            //     'join_date' => now()->subDays(rand(30, 1500)),
            //     'employment_status' => rand(0, 1) ? 'permanent' : 'contract',
            //     'salary' => rand(5000000, 9000000),
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);


        }
    }
}
