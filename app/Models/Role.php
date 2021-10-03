<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Role extends Model
{
    use HasFactory  ;

    protected $fillable = [
        'name',
        'slug',


    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
