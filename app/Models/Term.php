<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'level',


    ];

    public function school_sessions()
    {
        return $this->belongsToMany(SchoolSession::class)->withTimestamps()->withPivot('status');
    }
}
