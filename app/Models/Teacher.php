<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'hire_date',
        'is_active',
        'user_id',
        'subject_id'
    ];

    /**
     * Relacionamento com o usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com a matéria
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * 🔥 RESTAURANDO: Relacionamento com turmas
     */
    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id')
                    ->withTimestamps();
    }

    /**
     * 🔥 RESTAURANDO: Relacionamento com turmas com contagem de alunos
     */
    public function classesWithStudentsCount()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id')
                    ->withCount('students')
                    ->withTimestamps();
    }

    /**
     * Acessor para o nome do usuário
     */
    public function getUserNameAttribute()
    {
        return $this->user->name ?? $this->name;
    }

    /**
     * Acessor para o email do usuário
     */
    public function getUserEmailAttribute()
    {
        return $this->user->email ?? $this->email;
    }

    /**
     * Verificar se o professor está ativo
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * 🔥 RESTAURANDO: Método para obter turmas com estudantes
     */
    public function getClassesWithStudents()
    {
        return $this->schoolClasses()->with('students')->get();
    }

    /**
     * 🔥 RESTAURANDO: Contar total de alunos
     */
    public function getTotalStudentsCount()
    {
        $total = 0;
        foreach ($this->schoolClasses as $class) {
            $total += $class->students->count();
        }
        return $total;
    }
}