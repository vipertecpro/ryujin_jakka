<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    protected $fillable = [
        'w_employee_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'status',
        'approved_by',
        'approved_remarks',
        'approved_at',
        'rejected_by',
        'rejected_reason',
        'rejected_at',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'w_employee_id')->with(['user']);
    }
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by')->with(['user']);
    }
    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'rejected_by')->with(['user']);
    }
}
