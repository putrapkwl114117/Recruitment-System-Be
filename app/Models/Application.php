<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Application; 

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'name', 'email', 'phone', 'experience', 'cv', 'portfolio'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}