<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected  $fillable = [
        'name',
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }


    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class)->withTimestamps();
    }
}
