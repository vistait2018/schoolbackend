<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=[
       'student_id',
        'school_session_id',
        'term_id',
        'general_bills_id',
        'amount_paid',
        'paid_for',
        'amount_to_pay',
        'collected',
        'isChecked'
    ];
}
