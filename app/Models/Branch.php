<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'country',
        'email',
        'code',
        'state',
        'phone',
        'address',
        'postal_code',
    ];
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class,'branch_id','id')->with(['user'])->whereHas('user');
    }
}
