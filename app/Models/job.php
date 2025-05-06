<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job; 

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'salary',
        'category',
        'location',
        'type',
        'experience_level',
        'skills',
        'image',
    ];

     public function applications()
    {
        return $this->hasMany(Application::class);
    }
}