<?php

namespace Database\Seeders;

use App\Models\Designation;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DesignationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $designations = [
            'AREA HEAD',
            'ADMIN MANAGER',
            'CONSULTANT',
            'SENIOR CONSULTANT',
            'CONSULTANT DERMATOLOGIST',
            'CONSULTANT DOCTOR',
            'CALL CENTER EXECUTIVE',
            'DOCTOR',
            'HAIR TRANSPLANT SURGEON',
            'CLIENT RELATIONSHIP EXECUTIVE',
            'DOCTOR ASSISTANT',
            'OFFICE ADMIN',
            'ACCOUNTANT',
            'CLINIC IN CHARGE',
            'ASST CLINIC HEAD',
            'CLINIC HEAD',
            'CHIEF EXECUTIVE OFFICER',
            'MANAGING DIRECTOR',
            'MEDICAL HEAD',
            'CORPORATE TRAINER',
            'Regional Business Development Manager',
            'Marketing Manager',
            'IN-HOUSE MANAGER',
            'HAIR TECHNICIAN',
            'PRO',
            'ASSISTANT CENTER MANAGER',
            'ASSISTANT DOCTOR',
            'THERAPIST',
            'DIETITIAN',
            'Therapy assistant',
            'CENTER MANAGER',
            'Branch accountant',
            'HOUSE KEEPING',
            'COUNSELOR',
            'LIPO THERAPIST',
            'ASSISTANT HR MANAGER',
            'REGIONAL MANGER',
            'REGIONAL RESULT MANAGER',
            'GENERAL MANAGER',
            'SENIOR OFFICE ASSISTANT',
            'EXECUTIVE',
            'LIAISON OFFICER',
            'EXECUTIVE ACCOUNTS',
            'SR.EXECUTIVE ACCOUNTS',
            'RESULTS MANAGER',
            'ASST. MANAGER',
            'TRAINING MANAGER',
            'SR.SALES MANAGER',
            'HR',
            'REGIONAL MANAGER',
            'PHYSIO THERAPIST',
            'CORPORATE MANAGER',
            'FRONT OFFICE EXECUTIVE',
            'OPERATIONAL MANAGER',
        ];
        foreach ($designations as $designation) {
            Designation::create([
                'name' => Str::of($designation)->upper(),
                'description' => $faker->sentence,
            ]);
        }
    }
}
