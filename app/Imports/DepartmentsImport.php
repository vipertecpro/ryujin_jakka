<?php

namespace App\Imports;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     *
     * @return Model
     */
    public function model(array $row): Model
    {
        return Department::updateOrCreate(
            [
                'name' => $row['name'],
            ],
            [
                'description' => @$row['description'] ?? '',
                'status' => 'active',
            ]
        );
    }
    public function headingRow(): int
    {
        return 1;
    }
}
