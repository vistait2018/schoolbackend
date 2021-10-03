<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable=[
        'name'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    public function departments()
    {
        return $this->belongsToMany(Department::class)->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->withPivot(['school_session_id','term_id']);
    }

    public function bills()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
