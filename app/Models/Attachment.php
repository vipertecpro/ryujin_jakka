<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'module_id',
        'uploaded_by',
        'module',
        'purpose',
        'file_original_name',
        'file_name',
        'file_path',
        'file_size',
        'file_extension',
        'file_mime_type',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'module_id', 'id');
    }
}
