<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //     $hrDept = DB::table('departments')
        //         ->where('name', 'Human Resource')
        //         ->first();

        //     $itDept = DB::table('departments')
        //         ->where('name', 'Information Technology')
        //         ->first();

        // $managerPosition = DB::table('positions')
        //     ->where('name', 'Manager')
        //     ->first();

        // $supervisorPosition = DB::table('positions')
        //     ->where('name', 'Supervisor')
        //     ->first();

        // $staffPosition = DB::table('positions')
        //     ->where('name', 'Staff')
        //     ->first();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),

            ],

            [
                'name' => 'HR Manager',
                'email' => 'hr.manager@example.com',
                'password' => Hash::make('password'),
            ],

            // [
            //     'name' => 'IT Supervisor',
            //     'email' => 'it.supervisor@example.com',
            //     'password' => Hash::make('password'),

            // ],

            // [
            //     'name' => 'Staff Employee',
            //     'email' => 'staff@example.com',
            //     'password' => Hash::make('password'),

            // ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );

            // Assign Role Spatie
            switch ($user->email) {
                case 'superadmin@example.com':
                    $user->assignRole('super-admin');
                    break;

                case 'hr.manager@example.com':
                    $user->assignRole('hrd');
                    break;

                // case 'dir.manager@example.com':
                //     $user->assignRole('direktur');
                //     break;

                // case 'it.supervisor@example.com':
                //     $user->assignRole('leader');
                //     break;

                // case
                // $user->assignRole('auditor');
                //     break;
                default:
                    $user->assignRole('employee');
                    break;
            }
        }
    }
}
