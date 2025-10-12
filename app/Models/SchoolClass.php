<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'numberClass',
    ];

    // ... outros métodos existentes ...

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id')
                    ->withTimestamps();
    }

    // Manter students para controle de matrícula
    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')
                    ->where('role', 'student')
                    ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id')
                    ->withTimestamps();
    }
   
}