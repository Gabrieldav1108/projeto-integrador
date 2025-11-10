<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'numberClass',
    ];

    /**
     * 🔄 CORREÇÃO: Relacionamento com professores através da tabela class_teacher
     * Agora usando o modelo Teacher
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id')
                    ->withTimestamps();
    }

    /**
     * ✅ CORRETO: Relacionamento com estudantes através da tabela class_user
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')
                    ->where('role', 'student')
                    ->withTimestamps();
    }

    /**
     * Relacionamento com matérias
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id')
                    ->withTimestamps();
    }

    public function classInformations(): HasMany
    {
        return $this->hasMany(ClassInformation::class, 'class_id');
    }

    /**
     * Contador de estudantes
     */
    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
    }
}