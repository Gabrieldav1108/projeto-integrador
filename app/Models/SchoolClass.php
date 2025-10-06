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

    public function informations()
    {
        return $this->hasMany(ClassInformation::class, 'class_id');
    }

    // CORREÇÃO DEFINITIVA - Remover o where duplicado
    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')
                    ->where('users.role', 'student') // Apenas UM where
                    ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id');
    }
}