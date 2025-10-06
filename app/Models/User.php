<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            // Verificar se a foto existe na pasta public/images/profiles
            if (file_exists(public_path('images/profiles/' . $this->foto))) {
                return asset('images/profiles/' . $this->foto);
            }
        }
        
        // Foto padrão caso não tenha
        return asset('img/sukuna.jpg');
    }

    /**
     * 🚦 Helpers para checar o papel do usuário
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
     * 🔄 CORREÇÃO: Relacionamento com turmas (MUITOS-PARA-MUITOS)
     */
    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_user', 'user_id', 'class_id')
                    ->withTimestamps();
    }

    /**
     * 🔄 NOVO: Relacionamento com turmas como professor
     */
    public function teachingClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id')
                    ->withTimestamps();
    }

    /**
     * Helper para obter a primeira turma do estudante (se houver)
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
        return $this->schoolClasses()->exists();
    }

    /**
     * Escopo para professores
     */
    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    /**
     * Escopo para estudantes
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    /**
     * Escopo para administradores
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * 🔄 NOVO: Escopo para usuários em uma turma específica
     */
    public function scopeInClass($query, $classId)
    {
        return $query->whereHas('schoolClasses', function($q) use ($classId) {
            $q->where('classes.id', $classId);
        });
    }

    /**
     * 🔄 NOVO: Escopo para usuários sem turma
     */
    public function scopeWithoutClass($query)
    {
        return $query->whereDoesntHave('schoolClasses');
    }
}