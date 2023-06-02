<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['enrollment', 'student_id', 'course_id', 'enrolled_at', 'status'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->enrollment = Str::random(10);
        });
    }
}
