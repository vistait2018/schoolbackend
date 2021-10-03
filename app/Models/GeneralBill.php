<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralBill extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'amount',
        'description',
        'type',
        'school_class_id'
    ];

    public function classes()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
