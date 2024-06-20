<?php

namespace App\Imports;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeaveRequestsImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     *
     * @return Model
     */
    public function model(array $row): Model
    {
        return LeaveRequest::updateOrCreate(
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
