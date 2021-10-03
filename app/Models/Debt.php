<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'general_bill_id' ,
        'student_id',
        'school_session_id',
        'term_id',
        'collected',
        'general_bill_amount',
        'general_bill_name',
        'school_class_id',
        'isChecked',
        'quantity',

    ];
}
