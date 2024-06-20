<?php

namespace Database\Seeders;

use App\Models\Department;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $departments = [
            'ADMINISTRATION',
            'SALES',
            'SKIN & HAIR',
            'SLIMMING',
            'SKIN & HAIR',
            'CALL CENTRE',
            'MARKETING',
            'Accounts',
            'Operations',
            'TRAINING',
            'HR',
            'HOUSE KEEPING',
            'FRONT OFFICE EXECUTIVE',
            'CORPORATE',
            'OPERATIONAL',
        ];
        foreach ($departments as $department) {
            Department::create([
                'name' => Str::of($department)->upper(),
                'description' => $faker->sentence,
            ]);
        }
    }
}
