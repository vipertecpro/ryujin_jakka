<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $developer = User::create([
            'name'              => 'Developer',
            'phone'             => '1234567890',
            'phone_verified_at' => now(),
            'email'             => 'developer@mailer.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'status'            => 'active',
            'last_login_at'     => now(),
            'last_login_ip'     => $faker->ipv4,
        ]);
        $developer->assignRole('developer');
    }
}
