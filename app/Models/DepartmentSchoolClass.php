<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentSchoolClass extends Model
{
    use HasFactory;

    protected $table = 'department_school_class';

    protected $fillable = [
        'department_id',
        'school_class_id'
    ];
}
