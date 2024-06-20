<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abilities = [
            'create',
            'edit',
            'read',
            'delete',
            'import',
            'export',
        ];

        $permissions_by_role = [
            'developer' => [
                'profile management',

                'global settings',
                'branch management',
                'mode of payment management',

                'users management',
                'roles management',
                'permissions management',

                'employees management',
                'department management',
                'designation management',

                'enquiries management',
                'media management',

                'customers management',
                'bookings management',
                'medical history management',
                'booking follow up management',
                'booking payments management',
                'booking sessions management',

                'treatments management',
                'treatment packages management',

                'leave types management',
                'leave requests management',
            ],
            'director' => [
                'profile management',

                'global settings',
                'branch management',
                'mode of payment management',

                'users management',
                'roles management',

                'employees management',
                'department management',
                'designation management',

                'enquiries management',
                'media management',

                'customers management',
                'bookings management',
                'medical history management',
                'booking follow up management',
                'booking payments management',
                'booking sessions management',

                'treatments management',
                'treatment packages management',

                'leave types management',
                'leave requests management',
            ],
            'ceo' => [
                'profile management',

                'users management',

                'employees management',
                'department management',
                'designation management',

                'enquiries management',

                'customers management',
                'bookings management',
                'medical history management',
                'booking follow up management',
                'booking payments management',
                'booking sessions management',

                'treatments management',
                'treatment packages management',

                'leave types management',
                'leave requests management',
            ],
            'area-manager' => [
                'profile management',

                'users management',

                'enquiries management',

                'customers management',
                'bookings management',
                'medical history management',
                'booking follow up management',
                'booking payments management',
                'booking sessions management',

                'treatment packages management',

                'leave requests management',
            ],
            'consultant' => [
                'profile management',

                'customers management',
                'bookings management',
                'medical history management',
                'booking follow up management',
                'booking payments management',
                'booking sessions management',

                'leave requests management',
            ],
            'telemarketers' => [
                'profile management',

                'enquiries management',

                'leave requests management',
            ],
            'doctor' => [
                'profile management',

                'bookings management',
                'medical history management',
                'booking follow up management',
                'booking payments management',
                'booking sessions management',

                'leave requests management',
            ],
            'doctor-assistant' => [
                'profile management',
                'booking sessions management',

                'leave requests management',
            ],
            'customer' => [
                'profile management',
                'bookings management',
            ],
        ];

        foreach ($permissions_by_role['developer'] as $permission) {
            foreach ($abilities as $ability) {
                Permission::create(['name' => $ability . ' ' . $permission]);
            }
        }

        foreach ($permissions_by_role as $role => $permissions) {
            $full_permissions_list = [];
            foreach ($abilities as $ability) {
                foreach ($permissions as $permission) {
                    $full_permissions_list[] = $ability . ' ' . $permission;
                }
            }
            Role::create(['name' => $role])->syncPermissions($full_permissions_list);
        }
    }
}
