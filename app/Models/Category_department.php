<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_department extends Model
{
    use HasFactory;
    protected  $table= 'category_department';

    protected $fillable =[
        'department_id',
        'category_id'
    ];
}
