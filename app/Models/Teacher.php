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
     * ✅ CORRETO: Relacionamento com o usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ✅ CORRETO: Relacionamento com a matéria
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * ✅ CORRETO: Relacionamento com turmas através da tabela class_teacher
     */
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id')
                    ->withTimestamps();
    }
}