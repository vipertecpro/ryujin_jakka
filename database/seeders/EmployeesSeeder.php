<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\Employee;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $director = User::create([
            'name'              => 'Director',
            'phone'             => '1234567890',
            'phone_verified_at' => now(),
            'email'             => 'director@mailer.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'status'            => 'active',
            'last_login_at'     => now(),
            'last_login_ip'     => $faker->ipv4,
        ]);
        $director->assignRole('director');

        $ceo = User::create([
            'name'              => 'CEO',
            'phone'             => '1234567890',
            'phone_verified_at' => now(),
            'email'             => 'ceo@mailer.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'status'            => 'active',
            'last_login_at'     => now(),
            'last_login_ip'     => $faker->ipv4,
        ]);
        $ceo->assignRole('ceo');
        $branches = Branch::all();
        foreach ($branches as $branch){
            /**
             * Branch - Area Manager
             * */
            $areaManager = User::create([
                'name'              => 'Area Manager - '.$branch->id,
                'phone'             => $faker->phoneNumber,
                'phone_verified_at' => now(),
                'email'             => 'areamanager'.$branch->id.'@mailer.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'status'            => 'active',
                'last_login_at'     => now(),
                'last_login_ip'     => $faker->ipv4,
            ]);
            Employee::create([
                'user_id' => $areaManager->id,
                'branch_id' => $branch->id,
                'department_id' => 1,
                'designation_id' => 1,
                'date_of_birth' => now(),
                'date_of_joining' => now(),
                'pan_number' => '123456789',
                'employee_code' => 'EMP'.$branch->id.'001',
                'personal_number' => $faker->phoneNumber,
                'current_address' => $faker->address,
                'permanent_address' => $faker->address,
            ]);
            $areaManager->assignRole('area-manager');
            /**
             * Branch - Consultant
             * */
            $consultant = User::create([
                'name'              => 'Consultant - '.$branch->id,
                'phone'             => $faker->phoneNumber,
                'phone_verified_at' => now(),
                'email'             => 'consultant'.$branch->id.'@mailer.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'status'            => 'active',
                'last_login_at'     => now(),
                'last_login_ip'     => $faker->ipv4,
            ]);
            $consultant->assignRole('consultant');
            Employee::create([
                'user_id' => $consultant->id,
                'branch_id' => $branch->id,
                'department_id' => 3,
                'designation_id' => 3,
                'date_of_birth' => now(),
                'date_of_joining' => now(),
                'pan_number' => '123456789',
                'employee_code' => 'EMP'.$branch->id.'002',
                'personal_number' => $faker->phoneNumber,
                'current_address' => $faker->address,
                'permanent_address' => $faker->address,
            ]);
            /**
             * Branch - Telemarketers
             * */
            $telemarketer = User::create([
                'name'              => 'Telemarketer - '.$branch->id,
                'phone'             => $faker->phoneNumber,
                'phone_verified_at' => now(),
                'email'             => 'telemarketer'.$branch->id.'@mailer.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'status'            => 'active',
                'last_login_at'     => now(),
                'last_login_ip'     => $faker->ipv4,
            ]);
            $telemarketer->assignRole('telemarketers');
            Employee::create([
                'user_id' => $telemarketer->id,
                'branch_id' => $branch->id,
                'department_id' => 6,
                'designation_id' => 7,
                'date_of_birth' => now(),
                'date_of_joining' => now(),
                'pan_number' => '123456789',
                'employee_code' => 'EMP'.$branch->id.'003',
                'personal_number' => $faker->phoneNumber,
                'current_address' => $faker->address,
                'permanent_address' => $faker->address,
            ]);
            /**
             * Branch - Doctor
             * */
            $doctor = User::create([
                'name'              => 'Doctor - '.$branch->id,
                'phone'             => $faker->phoneNumber,
                'phone_verified_at' => now(),
                'email'             => 'doctor'.$branch->id.'@mailer.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'status'            => 'active',
                'last_login_at'     => now(),
                'last_login_ip'     => $faker->ipv4,
            ]);
            $doctor->assignRole('doctor');
            Employee::create([
                'user_id' => $doctor->id,
                'branch_id' => $branch->id,
                'department_id' => 3,
                'designation_id' => 8,
                'date_of_birth' => now(),
                'date_of_joining' => now(),
                'pan_number' => '123456789',
                'employee_code' => 'EMP'.$branch->id.'004',
                'personal_number' => $faker->phoneNumber,
                'current_address' => $faker->address,
                'permanent_address' => $faker->address,
            ]);
            /**
             * Branch - Doctor Assistant
             * */
            $doctorAssistant = User::create([
                'name'              => 'Doctor Assistant - '.$branch->id,
                'phone'             => $faker->phoneNumber,
                'phone_verified_at' => now(),
                'email'             => 'doctorassistant'.$branch->id.'@mailer.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'status'            => 'active',
                'last_login_at'     => now(),
                'last_login_ip'     => $faker->ipv4,
            ]);
            $doctorAssistant->assignRole('doctor-assistant');
            Employee::create([
                'user_id' => $doctorAssistant->id,
                'branch_id' => $branch->id,
                'department_id' => 3,
                'designation_id' => 9,
                'date_of_birth' => now(),
                'date_of_joining' => now(),
                'pan_number' => '123456789',
                'employee_code' => 'EMP'.$branch->id.'005',
                'personal_number' => $faker->phoneNumber,
                'current_address' => $faker->address,
                'permanent_address' => $faker->address,
            ]);

        }
    }
}
