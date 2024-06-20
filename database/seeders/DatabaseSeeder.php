<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesPermissionsSeeder::class,

            DesignationsSeeder::class,
            DepartmentsSeeder::class,
            BranchesSeeder::class,

            UsersSeeder::class,
            EmployeesSeeder::class,

            LeaveTypesTableSeeder::class,
            LeaveRequestsSeeder::class,
        ]);
    }
}
