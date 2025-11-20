<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'foto_url',
        'total_students', 
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento com turmas como professor através do modelo Teacher
     */
    public function teacherClasses()
    {
        return $this->hasManyThrough(
            SchoolClass::class,
            Teacher::class,
            'user_id', // Foreign key on teachers table
            'id', // Foreign key on classes table
            'id', // Local key on users table
            'id' // Local key on teachers table
        )->join('class_teacher', 'classes.id', '=', 'class_teacher.class_id')
         ->where('class_teacher.teacher_id', '=', DB::raw('teachers.id'));
    }

    /**
     * Relacionamento com turmas como estudante (usando class_user)
     */
    public function studentClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_user', 'user_id', 'class_id')
                    ->withTimestamps();
    }

    /**
     * Relacionamento com o perfil do professor
     */
    public function teacherProfile()
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    /**
     * 🔥 MÉTODO CORRIGIDO: Para obter turmas do professor
     */
    public function getTeachingClasses()
    {
        if (!$this->isTeacher() || !$this->teacherProfile) {
            return collect();
        }

        // Usa o método schoolClasses do modelo Teacher
        return $this->teacherProfile->schoolClasses()->with('students')->get();
    }

    /**
     * 🔥 MÉTODO CORRIGIDO: Contador de alunos para professor
     */
    public function getTotalStudentsAttribute()
    {
        if (!$this->isTeacher() || !$this->teacherProfile) {
            return 0;
        }

        return DB::table('class_teacher')
            ->join('class_user', 'class_teacher.class_id', '=', 'class_user.class_id')
            ->join('users', 'class_user.user_id', '=', 'users.id')
            ->where('class_teacher.teacher_id', $this->teacherProfile->id)
            ->where('users.role', 'student')
            ->distinct('users.id')
            ->count('users.id');
    }

    /**
     * Acessor para obter as turmas baseado no role
     */
    public function getClassesAttribute()
    {
        if ($this->isTeacher()) {
            return $this->getTeachingClasses();
        } elseif ($this->isStudent()) {
            return $this->studentClasses;
        }
        
        return collect();
    }

    /**
     * Acessor para a matéria principal do professor
     */
    public function getMainSubjectAttribute()
    {
        if ($this->isTeacher() && $this->teacherProfile) {
            return $this->teacherProfile->subject;
        }
        return null;
    }

    /**
     * Obter matérias como coleção
     */
    public function getSubjectsCollectionAttribute()
    {
        if ($this->isTeacher() && $this->teacherProfile && $this->teacherProfile->subject) {
            return collect([$this->teacherProfile->subject]);
        }
        
        return collect();
    }

    /**
     * Verificar se o professor tem matéria atribuída
     */
    public function hasSubject(): bool
    {
        return $this->isTeacher() && $this->teacherProfile && $this->teacherProfile->subject;
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            if (file_exists(public_path('images/profiles/' . $this->foto))) {
                return asset('images/profiles/' . $this->foto);
            }
        }
        
        return asset('img/sukuna.jpg');
    }

    /**
     * Helpers para checar o papel do usuário
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Relacionamento geral com turmas (para estudantes)
     */
    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_user', 'user_id', 'class_id')
                    ->withTimestamps();
    }

    /**
     * Helper para obter a primeira turma do estudante
     */
    public function getFirstClassAttribute()
    {
        if ($this->isStudent()) {
            return $this->schoolClasses->first();
        }
        return null;
    }

    /**
     * Helper para verificar se o usuário está em alguma turma
     */
    public function hasClasses(): bool
    {
        if ($this->isTeacher()) {
            return $this->getTeachingClasses()->count() > 0;
        } elseif ($this->isStudent()) {
            return $this->studentClasses()->exists();
        }
        return false;
    }

    // Escopos...
    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * 🔥 MÉTODO QUE ESTAVA FALTANDO: Para HomeController
     */
    public function getTeacherProfile()
    {
        return $this->teacherProfile;
    }
}