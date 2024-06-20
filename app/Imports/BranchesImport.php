<?php

namespace App\Imports;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BranchesImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     *
     * @return Model
     */
    public function model(array $row): Model
    {
        return Branch::updateOrCreate(
            [
                'name' => $row['name'],
                'country' => $row['country'],
                'email' => $row['email'],
                'code' => $row['code'],
                'state' => $row['state'],
                'phone' => $row['phone'],
                'postal_code' => $row['postal_code'],
            ],
            [
                'name' => $row['name'],
                'country' => $row['country'],
                'email' => $row['email'],
                'code' => $row['code'],
                'state' => $row['state'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'postal_code' => $row['postal_code'],
            ]
        );

    }
    public function headingRow(): int
    {
        return 1;
    }
}
