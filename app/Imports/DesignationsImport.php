<?php

namespace App\Imports;

use App\Models\Designation;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DesignationsImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     *
     * @return Model
     */
    public function model(array $row): Model
    {
        return Designation::updateOrCreate(
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
