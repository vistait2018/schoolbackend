<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSessionTerm extends Model
{
    use HasFactory;
    protected $table = 'school_session_term';

    protected $fillable = [
        'term_id',
        'school_session_id',
        'status',

    ];
}
