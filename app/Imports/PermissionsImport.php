<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Branch;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermissionsImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     *
     * @return Model|User|null
     */
    public function model(array $row): Model|User|null
    {
        try{
            $getBranch = Branch::where('name', $row['branch'])->first();

            $row['date_of_joining'] = $row['date_of_joining'] ? Carbon::parse($row['date_of_joining'])->format('Y-m-d H:i:s') : Carbon::now()->format('Y-m-d H:i:s');

            $row['date_of_birth'] = $row['date_of_birth'] ? Carbon::parse($row['date_of_birth'])->format('Y-m-d H:i:s') : Carbon::now()->format('Y-m-d H:i:s');

            $user =  User::create([
                'name'              => $row['employee_name'],
                'employee_number'   => $row['employee_no'],
                'email'             => Str::of($row['employee_name'])->lower()->slug() . '@mailer.com',
                'password'          => Hash::make('password'),
                'designation'       => $row['designation'],
                'date_of_joining'   => $row['date_of_joining'],
                'date_of_birth'     => $row['date_of_birth'],
                'pan_number'        => $row['pan_number'],
                'branch_id'         => $getBranch->id ?? 0,
            ]);
            $user->assignRole('customer');
            return $user;
        }catch (Exception $exception){
            dd($exception);
        }
    }
    public function headingRow(): int
    {
        return 1;
    }
}
