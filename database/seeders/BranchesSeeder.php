<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'name'        => 'HO',
                'country'     => 'India',
                'email'       => 'mailer1234@gmail.com',
                'code'        => 'HO',
                'state'       => 'Karnataka',
                'phone'       => '044-40114444',
                'address'     => 'hyd',
                'postal_code' => '231265',
            ],[
                'name'        => 'Anna Nagar',
                'country'     => 'India',
                'email'       => 'mailer1234@gmail.com',
                'code'        => 'AN',
                'state'       => 'Tamil Nadu',
                'phone'       => '044-40114444',
                'address'     => 'mailer health care Pvt Ltd, west wood building, old number y-205, new number 32, 1st floor 5th Avenue, Anna nagar west, Chennai 600040',
                'postal_code' => '600040',
            ],[
                'name'        => 'Adyar',
                'country'     => 'India',
                'email'       => 'mailer1234@gmail.com',
                'code'        => 'ADYAR',
                'state'       => 'Tamil Nadu',
                'phone'       => '044-40114444',
                'address'     => 'No 163, Sms building L B road (Opp to L B road Bus depo), Thiruvanmiyur Chennai 600041',
                'postal_code' => '600041',
            ],[
                'name'        => 'T Nagar',
                'country'     => 'India',
                'email'       => 'mailer1234@gmail.com',
                'code'        => 'TN',
                'state'       => 'Tamil Nadu',
                'phone'       => '044-40114444',
                'address'     => 'mailer health care Pvt Ltd, No.24/1, Raman Street, Parthasarathi puram (Behind Residency Towers), T.Nagar, Chennai-600017',
                'postal_code' => '600017',
            ]
        ];
        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
