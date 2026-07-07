<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [

            'dashboard.view',

            'employee.view',
            'employee.create',
            'employee.edit',
            'employee.delete',

            'division.view',
            'division.create',
            'division.edit',
            'division.delete',

            'department.view',
            'department.create',
            'department.edit',
            'department.delete',

            'position.view',
            'position.create',
            'position.edit',
            'position.delete',

            'period.view',
            'period.create',
            'period.edit',
            'period.delete',

            'kpi-master.view',
            'kpi-master.create',
            'kpi-master.edit',
            'kpi-master.delete',

            'kpi-indicator.view',
            'kpi-indicator.create',
            'kpi-indicator.edit',
            'kpi-indicator.delete',

            'kpi-target.view', //target untuk employee
            'kpi-target.create',
            'kpi-target.edit',
            'kpi-target.delete',

            'kpi-score.view', //score employee
            'kpi-score.create',
            'kpi-score.edit',
            'kpi-score.delete',

            'assessment.create',
            'assessment.approve',

            'abc.run',
            'abc.result.view',

            'mdp.run',
            'mdp.result.view',

            'reward.approve',

            'report.view',
            'audit.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $hrd = Role::firstOrCreate([
            'name' => 'hrd',
            'guard_name' => 'web',
        ]);

        $direktur = Role::firstOrCreate([
            'name' => 'direktur',
            'guard_name' => 'web',
        ]);

        $leader = Role::firstOrCreate([
            'name' => 'leader',
            'guard_name' => 'web',
        ]);

        $auditor = Role::firstOrCreate([
            'name' => 'auditor',
            'guard_name' => 'web',
        ]);

        $employee = Role::firstOrCreate([
            'name' => 'employee',
            'guard_name' => 'web',
        ]);

        // Super Admin
        $superAdmin->syncPermissions(
            Permission::all()
        );

        // HRD
        $hrd->syncPermissions([
            'dashboard.view',

            'employee.view',
            'employee.create',
            'employee.edit',

            'division.view',
            'department.view',
            'position.view',
            'period.view',

            'assessment.approve',

            'report.view',
        ]);

        // Direktur
        $direktur->syncPermissions([
            'dashboard.view',

            'assessment.approve',

            'abc.result.view',
            'mdp.result.view',

            'reward.approve',

            'report.view',
        ]);

        // Leader
        $leader->syncPermissions([
            'dashboard.view',

            'kpi-score.view',
            'kpi-score.create',
            'kpi-score.edit',

            'assessment.create',
        ]);

        // Auditor
        $auditor->syncPermissions([
            'dashboard.view',
            'audit.view',
            'report.view',
        ]);

        // Employee
        $employee->syncPermissions([
            'dashboard.view',
        ]);
    }
}
