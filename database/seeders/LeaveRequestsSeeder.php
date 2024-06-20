<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class LeaveRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::with(['employees'])->get();
        $leaveTypes = LeaveType::all();
        $statuses = ['pending', 'approved', 'rejected', 'cancelled'];
        $remarks = [
            'approved' => 'Enjoy your leave!',
        ];
        $reasons = [
            'rejected' => 'Your leave request is rejected due to some reasons.',
        ];
        foreach ($branches as $branch) {
            $employees = $branch->employees;
            $areaManager = $branch->employees->filter(function ($employee) {
                return $employee->user->role('area-manager');
            })->first();
            Log::info('Employees: ' . json_encode($employees));
            Log::info('Area Manager: ' . json_encode($areaManager));
            foreach ($employees as $employee) {
                $status = $statuses[array_rand($statuses)];
                $approvedBy = $status === 'approved' ? $areaManager->id : null;
                $rejectedBy = $status === 'rejected' ? $areaManager->id : null;
                $approvedRemarks = $status === 'approved' ? $remarks['approved'] : null;
                $rejectedReason = $status === 'rejected' ? $reasons['rejected'] : null;
                $approvedAt = $status === 'approved' ? now() : null;
                $rejectedAt = $status === 'rejected' ? now() : null;
                $getRandomLeaveType = $leaveTypes->random();
                $leaveType = $getRandomLeaveType->id;
                $leaveTotalDays = $getRandomLeaveType->total_days;
                $startDate = now()->subDays(rand(1, 10));
                $endDate = $startDate->copy()->addDays(rand(1, $leaveTotalDays));
                LeaveRequest::create([
                    'w_employee_id' => $employee->id,
                    'leave_type_id' => $leaveType,
                    'status' => $status,
                    'approved_by' => $approvedBy,
                    'approved_at' => $approvedAt,
                    'approved_remarks' => $approvedRemarks,
                    'rejected_by' => $rejectedBy,
                    'rejected_at' => $rejectedAt,
                    'rejected_reason' => $rejectedReason,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }
        }
    }
}
