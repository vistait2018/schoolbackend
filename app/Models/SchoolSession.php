<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'status',


    ];

    public function terms()
    {
        return $this->belongsToMany(Term::class)->withTimestamps()->withPivot('status');
    }
}
