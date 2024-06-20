<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'designation_id',
        'department_id',
        'date_of_birth',
        'date_of_joining',
        'pan_number',
        'employee_code',
        'personal_number',
        'current_address',
        'permanent_address',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'datetime',
        'date_of_joining' => 'datetime',
        'created_at' => 'datetime',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'module_id','id')->where('module', 'employees');
    }
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class,'w_employee_id','id');
    }
}
