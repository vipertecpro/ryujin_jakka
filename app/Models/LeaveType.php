<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [
        'name',
        'total_days',
        'type',
        'conditions'
    ];
    protected $casts = [
        'conditions' => 'array',
    ];
}
