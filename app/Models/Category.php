<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'school_id',
        'level',

    ];


    public function school(){
        return $this->belongsTo(School::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class)->withTimestamps();
    }
}
